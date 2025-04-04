<?php
// Include the database connection

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection
include('connection.php');
require 'vendor/autoload.php'; // Include PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!$conn) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed: ' . mysqli_connect_error()]);
    exit;
}

// Set headers for JSON response
header('Content-Type: application/json');

// Decode the JSON request body
$data = json_decode(file_get_contents('php://input'), true);

// Ensure the required fields are received
if (
    isset($data['transactionId']) &&
    isset($data['cryptoSymbol']) &&
    isset($data['amount']) &&
    isset($data['walletAddress']) &&
    isset($data['qrCode']) // QR Code added here
) {
    // Sanitize and assign input values
    $transactionId = mysqli_real_escape_string($conn, $data['transactionId']);
    $cryptoSymbol = mysqli_real_escape_string($conn, $data['cryptoSymbol']);
    $amount = mysqli_real_escape_string($conn, $data['amount']);
    $walletAddress = mysqli_real_escape_string($conn, $data['walletAddress']);
    $qrCode = mysqli_real_escape_string($conn, $data['qrCode']); // Sanitize the QR code

    // Fetch the user ID from the session
    session_start();
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'error' => 'User not logged in.']);
        exit;
    }
    $userId = $_SESSION['user_id'];

    // Insert payment details into the database
    $status = "Pending"; // Default status for new payments
    $transactionType = "deposit"; // Set the transaction type
    $query = "INSERT INTO transactions (user_id, transaction_id, crypto_symbol, amount, wallet_address, qr_code, transaction_type, status)
              VALUES ('$userId', '$transactionId', '$cryptoSymbol', '$amount', '$walletAddress', '$qrCode', '$transactionType', '$status')";

    // Execute the query and handle the result
    if (mysqli_query($conn, $query)) {
        // Send email notification
        $userQuery = "SELECT firstname, email FROM users WHERE user_id = '$userId'";
        $result = mysqli_query($conn, $userQuery);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            $userEmail = $user['email'];
            $userName = $user['firstname'];

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

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Deposit Received';
                $mail->Body = "
                    <p>Dear $userName,</p> 
                    <p>We have received your deposit request. Please find the details of your transaction below:</p> 
                    <ul> <li><strong>Transaction ID:</strong> $transactionId</li> 
                    <li><strong>Crypto Symbol:</strong> $cryptoSymbol</li> 
                    <li><strong>Amount:</strong> $amount</li> 
                    <li><strong>Wallet Address:</strong> $walletAddress</li> </ul> 
                    <p>At this time, your deposit is <strong>Pending</strong>. We will notify you as soon as the transaction is confirmed.</p> 
                    <p>If you have any questions, feel free to reach out to our support team.</p>
                    <p>Thank you for choosing Simart Pro!</p>
                ";

                $mail->send();

                // Notify Admin
                $mail->clearAddresses(); // Clear previous recipient
                $mail->addAddress('support@simartpro.com'); // Admin email
                $mail->Subject = 'New Deposit Notification';
                $mail->Body = "
                    <p>Admin,</p>
                    <p>A new deposit request has been received with the following details:</p>
                    <ul>
                        <li><strong>User Name:</strong> $userName</li>
                        <li><strong>User ID:</strong> $userId</li>
                        <li><strong>Transaction ID:</strong> $transactionId</li>
                        <li><strong>Crypto Symbol:</strong> $cryptoSymbol</li>
                        <li><strong>Amount:</strong> $amount</li>
                        <li><strong>Wallet Address:</strong> $walletAddress</li>
                    </ul>
                    <p>Kindly review and confirm the deposit status in the admin panel.</p>
                    <p>Simart Pro Admin</p>
                ";

                $mail->send();

                
            } catch (Exception $e) {
                error_log("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
            }
        }

        // Send deposit notification
        sendDepositNotification($userId, $amount);

        echo json_encode(['success' => true]);
    } else {
        // Respond with an error if the query fails
        echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
    }
} else {
    // Respond with an error if required fields are missing
    echo json_encode(['success' => false, 'error' => 'Invalid input data.']);
}

// Function to send deposit notification
function sendDepositNotification($userId, $amount) {
    global $conn;

    // Construct the notification message
    $message = "A deposit of $amount has been made to your account.";

    // Insert notification into the database
    $query = "INSERT INTO notifications (user_id, message) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('is', $userId, $message);
    $stmt->execute();
}

// Close the database connection
mysqli_close($conn);
?>