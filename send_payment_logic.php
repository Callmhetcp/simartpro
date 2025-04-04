<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('connection.php');
require 'vendor/autoload.php'; // Include PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!$conn) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed: ' . mysqli_connect_error()]);
    exit;
}

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (
    isset($data['transactionId']) &&
    isset($data['cryptoSymbol']) &&
    isset($data['amount']) &&
    isset($data['walletAddress'])
) {
    $transactionId = mysqli_real_escape_string($conn, $data['transactionId']);
    $cryptoSymbol = mysqli_real_escape_string($conn, $data['cryptoSymbol']);
    $amount = mysqli_real_escape_string($conn, $data['amount']);
    $walletAddress = mysqli_real_escape_string($conn, $data['walletAddress']);

    session_start();
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'error' => 'User not logged in.']);
        exit;
    }
    $userId = $_SESSION['user_id'];

    // Separate KYC query to check KYC details
    $kycQuery = "SELECT dob, address, gov_id, id_number, status FROM kyc_details WHERE user_id = '$userId'";
    $result = mysqli_query($conn, $kycQuery);

    if (!$result) {
        echo json_encode(['success' => false, 'error' => 'Error checking KYC details: ' . mysqli_error($conn)]);
        exit;
    }

    if (mysqli_num_rows($result) === 0) {
        echo json_encode(['success' => false, 'error' => 'KYC details not found. Please complete your KYC.']);
        exit;
    }

    $row = mysqli_fetch_assoc($result);

    // Send email for KYC status (whether verified or not)
    $userQuery = "SELECT firstname, email FROM users WHERE user_id = '$userId'";
    $userResult = mysqli_query($conn, $userQuery);

    if ($userResult && mysqli_num_rows($userResult) > 0) {
        $user = mysqli_fetch_assoc($userResult);
        $userName = $user['firstname'];
        $userEmail = $user['email'];
    } else {
        echo json_encode(['success' => false, 'error' => 'Error retrieving user email.']);
        exit;
    }

    // Email based on KYC status
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'server305.web-hosting.com'; // Set SMTP server
                $mail->SMTPAuth = true;
                $mail->Username = 'support@simartpro.com'; // SMTP username
                $mail->Password = 'simartpro.com'; // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
        
                // Recipients
                $mail->setFrom('support@simartpro.com', 'SimartPro Admin');
        $mail->addAddress($userEmail);

        // Content based on KYC status
        if ($row['status'] != 'Verified') {
            $mail->isHTML(true);
            $mail->Subject = 'KYC Status Update - Action Required';
            $mail->Body = "
                <p>Dear $userName,</p>
                <p>We noticed that your KYC status is currently <strong>unverified</strong>.</p>
                <p>Please complete your KYC process in order to proceed with withdrawals.</p>
                <p>Thank you for choosing Simart Pro!</p>
            ";
        } else {
            $mail->isHTML(true);
            $mail->Subject = 'KYC Status Update - Verified';
            $mail->Body = "
                <p>Dear $userName,</p>
                <p>We are pleased to inform you that your KYC status is <strong>verified</strong>.</p>
                <p>You are now eligible to proceed with withdrawals and other actions on your account.</p>
                <p>Thank you for choosing Simart Pro!</p>
            ";
        }

        $mail->send();
    } catch (Exception $e) {
        error_log("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }

    // Proceed with the withdrawal process after KYC check
    if (
        empty($row['dob']) ||
        empty($row['address']) ||
        empty($row['gov_id']) ||
        empty($row['id_number'])
    ) {
        echo json_encode(['success' => false, 'error' => 'Incomplete KYC details. Please complete your KYC before withdrawing.']);
        exit;
    }

    if ($row['status'] != 'Verified') {
        echo json_encode(['success' => false, 'error' => 'Your KYC status is unverified. Withdrawal is not allowed.']);
        exit;
    }

    if (!is_numeric($amount) || $amount <= 0) {
        echo json_encode(['success' => false, 'error' => 'Invalid amount. Please enter a positive number.']);
        exit;
    }

    $status = "Pending";
    $transactionType = "Withdrawal";

    // Insert transaction into the database
    $query = "INSERT INTO transactions (user_id, transaction_id, crypto_symbol, amount, wallet_address, transaction_type, status)
              VALUES ('$userId', '$transactionId', '$cryptoSymbol', '$amount', '$walletAddress', '$transactionType', '$status')";

    if (mysqli_query($conn, $query)) {
        // Send withdrawal notification
        sendWithdrawalNotification($userId, $amount, $cryptoSymbol, $walletAddress, $transactionId);

        // Send withdrawal email to user
        $mail->clearAddresses(); // Clear previous email address
        $mail->addAddress($userEmail); // Add user email for withdrawal notification

        $mail->isHTML(true);
        $mail->Subject = 'Withdrawal Request Received';
        $mail->Body = "
            <p>Dear $userName,</p>
            <p>We have received your withdrawal request with the following details:</p>
            <ul>
                <li><strong>Transaction ID:</strong> $transactionId</li>
                <li><strong>Crypto Symbol:</strong> $cryptoSymbol</li>
                <li><strong>Amount:</strong> $amount</li>
                <li><strong>Wallet Address:</strong> $walletAddress</li>
            </ul>
            <p>Your withdrawal status is currently <strong>Pending</strong>. We will notify you once it is processed.</p>
            <p>Thank you for choosing Simart Pro!</p>
        ";

        $mail->send();

        // Notify Admin
        $mail->clearAddresses(); // Clear previous recipient
        $mail->addAddress('support@simartpro.com'); // Admin email
        $mail->Subject = 'New Withdrawal Notification';
        $mail->Body = "
            <p>Admin,</p>
            <p>A new withdrawal request has been received with the following details:</p>
            <ul>
                <li><strong>User Name:</strong> $userName</li>
                <li><strong>User ID:</strong> $userId</li>
                <li><strong>Transaction ID:</strong> $transactionId</li>
                <li><strong>Crypto Symbol:</strong> $cryptoSymbol</li>
                <li><strong>Amount:</strong> $amount</li>
                <li><strong>Wallet Address:</strong> $walletAddress</li>
            </ul>
            <p>Kindly review and confirm the withdrawal status in the admin panel.</p>
            <p>Simart Pro Admin</p>
        ";

        $mail->send();


        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Error inserting transaction: ' . mysqli_error($conn)]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid input data.']);
}

mysqli_close($conn);

// Function to send withdrawal notification
function sendWithdrawalNotification($userId, $amount, $cryptoSymbol, $walletAddress, $transactionId) {
    global $conn;

    // Construct the notification message
    $message = "A withdrawal of $amount $cryptoSymbol has been requested to the wallet address: $walletAddress. Transaction ID: $transactionId.";

    // Insert notification into the database
    $query = "INSERT INTO notifications (user_id, message) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('is', $userId, $message);
    $stmt->execute();
}
?>

