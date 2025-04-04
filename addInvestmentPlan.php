<?php
session_start();
include 'connection.php';
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'vendor/autoload.php'; // Include PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Log function to write messages to log.txt
function logMessage($message) {
    $logFile = 'log.txt';
    $currentDateTime = date('Y-m-d H:i:s');
    $logMessage = "[{$currentDateTime}] {$message}\n";
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}

// Generate a unique transaction ID
function txn_time() {
    return uniqid('txn_');
}

// Function to send investment notification
function sendInvestmentNotification($userId, $amount, $cryptoSymbol) {
    global $conn;

    // Construct the notification message
    $message = "You have successfully made an investment of $amount in $cryptoSymbol. Your investment is currently processing.";

    // Insert notification into the database
    $query = "INSERT INTO notifications (user_id, message) VALUES (?, ?)";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('is', $userId, $message);
        $stmt->execute();
        logMessage("Investment notification inserted for User ID: {$userId}");
    } else {
        logMessage("Error inserting investment notification: " . $conn->error);
    }
}

// Read and decode the raw JSON input
$requestBody = file_get_contents('php://input');
$data = json_decode($requestBody, true);

// Log the raw input for debugging
logMessage("Raw input: " . $requestBody);

// Validate and retrieve parameters from the request body
if (isset($data['crypto_id'], $data['plan_id'], $data['investment_amount'])) {
    $crypto_id = intval($data['crypto_id']);
    $plan_id = intval($data['plan_id']);
    $investment_amount = floatval($data['investment_amount']);
} else {
    logMessage("Missing required parameters in request body.");
    echo json_encode(['success' => false, 'message' => 'Missing required parameters.']);
    exit();
}

// Retrieve user_id from session
$user_id = $_SESSION['user_id'] ?? null;

if ($user_id === null) {
    logMessage("User is not logged in.");
    echo json_encode(['success' => false, 'message' => 'User is not logged in.']);
    exit();
}

logMessage("Received investment request. User ID: {$user_id}, Crypto ID: {$crypto_id}, Plan ID: {$plan_id}, Investment Amount: {$investment_amount}");

// Fetch the crypto symbol for the given crypto_id
$crypto_query = "SELECT symbol FROM cryptos WHERE crypto_id = ?";
if ($stmt_crypto = $conn->prepare($crypto_query)) {
    $stmt_crypto->bind_param("i", $crypto_id);
    $stmt_crypto->execute();
    $stmt_crypto->store_result();
    $stmt_crypto->bind_result($crypto_symbol);
    if (!$stmt_crypto->fetch()) {
        logMessage("Invalid crypto_id: {$crypto_id}");
        echo json_encode(['success' => false, 'message' => 'Invalid cryptocurrency.']);
        exit();
    }
    $stmt_crypto->close();
} else {
    logMessage("Error preparing crypto query: " . $conn->error);
    echo json_encode(['success' => false, 'message' => 'Error fetching cryptocurrency symbol.']);
    exit();
}

logMessage("Crypto symbol found: {$crypto_symbol} for crypto_id: {$crypto_id}");

// Fetch the investment plan details
$plan_query = "SELECT * FROM investment_plan WHERE id = ?";
if ($stmt_plan = $conn->prepare($plan_query)) {
    $stmt_plan->bind_param("i", $plan_id);
    $stmt_plan->execute();
    $plan_result = $stmt_plan->get_result();

    if ($plan_result->num_rows > 0) {
        $plan = $plan_result->fetch_assoc();
        $min_investment = floatval($plan['minimum']);
        $max_investment = floatval($plan['maximum']);
        $roi = floatval($plan['roi']);

        // Validate investment amount
        if ($investment_amount < $min_investment || $investment_amount > $max_investment) {
            logMessage("Investment validation failed. Amount not within range.");
            echo json_encode(['success' => false, 'message' => "Investment amount must be between {$min_investment} and {$max_investment}."]);
            exit();
        }

        // Deduct the investment amount from the user's balance
        $user_balance_query = "SELECT balance FROM users WHERE user_id = ?";
        if ($stmt_balance = $conn->prepare($user_balance_query)) {
            $stmt_balance->bind_param("i", $user_id);
            $stmt_balance->execute();
            $stmt_balance->store_result();
            $stmt_balance->bind_result($current_balance);
            if ($stmt_balance->fetch() && $current_balance >= $investment_amount) {
                $new_balance = $current_balance - $investment_amount;

                // Update the user's balance
                $update_balance_query = "UPDATE users SET balance = ? WHERE user_id = ?";
                if ($stmt_update_balance = $conn->prepare($update_balance_query)) {
                    $stmt_update_balance->bind_param("di", $new_balance, $user_id);
                    $stmt_update_balance->execute();
                    logMessage("User {$user_id}'s balance updated. New balance: {$new_balance}");
                } else {
                    logMessage("Failed to update user balance.");
                    echo json_encode(['success' => false, 'message' => 'Failed to update balance.']);
                    exit();
                }

                // Insert investment into the database
                $insert_investment_query = "INSERT INTO investments (user_id, plan_id, crypto_id, roi, amount, status, earnings, total_earnings) 
                                            VALUES (?, ?, ?, ?, ?, 'pending', 0.00, 0.00)";
                if ($stmt_investment = $conn->prepare($insert_investment_query)) {
                    $stmt_investment->bind_param("iiidd", $user_id, $plan_id, $crypto_id, $roi, $investment_amount);
                    $stmt_investment->execute();
                    logMessage("Investment added successfully for User ID: {$user_id}");

                    // Insert transaction record
                    $wallet_address = 'investment';
                    $transaction_id = txn_time();
                    $transaction_query = "INSERT INTO transactions (transaction_id, user_id, crypto_symbol, amount, transaction_type, wallet_address, status) 
                                          VALUES (?, ?, ?, ?, 'withdrawal', ?, 'completed')";
                    if ($stmt_transaction = $conn->prepare($transaction_query)) {
                        $stmt_transaction->bind_param("sisds", $transaction_id, $user_id, $crypto_symbol, $investment_amount, $wallet_address);
                        $stmt_transaction->execute();
                        logMessage("Transaction added successfully. Transaction ID: {$transaction_id}, User ID: {$user_id}, Amount: {$investment_amount}");

                        // Send email notification
                        $userQuery = "SELECT firstname, email FROM users WHERE user_id = '$user_id'";
                        $result = mysqli_query($conn, $userQuery);

                        if ($result && mysqli_num_rows($result) > 0) {
                            $user = mysqli_fetch_assoc($result);
                            $userEmail = $user['email'];
                            $userName = $user['firstname'];

                            $mail = new PHPMailer(true);
                            try {
                                // Server settings
                                $mail->isSMTP();
                                $mail->Host = 'server187.web-hosting.com'; // Set SMTP server
                                $mail->SMTPAuth = true;
                                $mail->Username = 'support@oceanfortune.bond'; // SMTP username
                                $mail->Password = 'oceanfortune.bond'; // SMTP password
                                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                                $mail->Port = 587;

                                // Recipients
                                $mail->setFrom('support@oceanfortune.bond', 'Simart Pro Admin');
                                $mail->addAddress($userEmail);

                                // Content
                                $mail->isHTML(true);
                                $mail->Subject = 'Investment Confirmation';
                                $mail->Body = "
                                        <p>Hi $userName,</p>

                                        <p>Thank you for choosing Simart Pro! We&apos;re excited to let you know that we&apos;ve received your investment of $investment_amount in $crypto_symbol.</p>

                                        <p>At the moment, your investment status is <em>processing</em>. We&apos;ll keep you updated as soon as it&apos;s completed and provide any additional details you need.</p>

                                        <p>If you have any questions or need assistance, feel free to reach out to our support team at any time.</p>

                                        <p>Thanks again for trusting us with your investment!</p>
                                        <p>Best regards,<br>Simart Pro Team</p>

                                ";

                                $mail->send();
                                logMessage("Investment email notification sent to $userEmail for Transaction ID: {$transaction_id}");
                            } catch (Exception $e) {
                                logMessage("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
                            }
                        }

                        // Send investment notification
                        sendInvestmentNotification($user_id, $investment_amount, $crypto_symbol);

                        echo json_encode(['success' => true, 'message' => 'Investment and transaction completed successfully.']);
                    } else {
                        logMessage("Failed to insert transaction: " . $conn->error);
                        echo json_encode(['success' => false, 'message' => 'Failed to process transaction.']);
                    }
                } else {
                    logMessage("Failed to add investment: " . $conn->error);
                    echo json_encode(['success' => false, 'message' => 'Failed to add investment.']);
                }
            } else {
                logMessage("Insufficient balance for User ID: {$user_id}.");
                echo json_encode(['success' => false, 'message' => 'Insufficient balance to make the investment.']);
            }
            $stmt_balance->close();
        }
    } else {
        logMessage("Investment plan not found for Plan ID: {$plan_id}");
        echo json_encode(['success' => false, 'message' => 'Investment plan not found.']);
    }
    $stmt_plan->close();
} else {
    logMessage("Error preparing plan query: " . $conn->error);
    echo json_encode(['success' => false, 'message' => 'Error fetching investment plan.']);
}
?>


