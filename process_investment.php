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

// Get the current date and time
$currentDateTime = new DateTime();

$processQuery = "SELECT * FROM investments WHERE status = 'pending'";
if ($stmt = $conn->prepare($processQuery)) {
    $stmt->execute();
    $result = $stmt->get_result();

    while ($investment = $result->fetch_assoc()) {
        $investment_id = $investment['investment_id'];
        $user_id = $investment['user_id'];
        $crypto_id = $investment['crypto_id']; // Fetch crypto_id
        $plan_id = $investment['plan_id'];
        $investment_amount = $investment['amount'];
        $current_earnings = $investment['earnings'];
        $total_earnings = $investment['total_earnings'];
        $created_at = new DateTime($investment['started_at']);
        $last_earning_time = new DateTime($investment['last_earning_time'] ?? $investment['started_at']); // Fallback to started_at

        // Fetch the plan details
        $planQuery = "SELECT * FROM investment_plan WHERE id = ?";
        if ($stmtPlan = $conn->prepare($planQuery)) {
            $stmtPlan->bind_param("i", $plan_id);
            $stmtPlan->execute();
            $planResult = $stmtPlan->get_result();
            $plan = $planResult->fetch_assoc();

            $roi = $plan['roi']; // ROI percentage (e.g., 2% daily)
            $duration_timeframe = $plan['duration_timeframe']; // Duration in days
            $earning_duration = $plan['earning_duration']; // Earning frequency in minutes

            // Get the crypto symbol from the cryptos table
            $cryptoSymbolQuery = "SELECT symbol FROM cryptos WHERE crypto_id = ?";
            $crypto_symbol = null;
            if ($stmtCrypto = $conn->prepare($cryptoSymbolQuery)) {
                $stmtCrypto->bind_param("i", $crypto_id);
                $stmtCrypto->execute();
                $cryptoResult = $stmtCrypto->get_result();
                if ($cryptoRow = $cryptoResult->fetch_assoc()) {
                    $crypto_symbol = $cryptoRow['symbol'];
                }
                $stmtCrypto->close();
            }

            if (!$crypto_symbol) {
                logMessage("Failed to fetch crypto symbol for crypto_id: {$crypto_id}");
                continue; // Skip to the next investment if crypto symbol is not found
            }

            // Calculate elapsed time since the last earnings update
            $elapsed = $last_earning_time->diff($currentDateTime);
            $elapsedMinutes = ($elapsed->days * 24 * 60) + ($elapsed->h * 60) + $elapsed->i;

            if ($elapsedMinutes >= $earning_duration) {
                // Calculate earnings for the elapsed periods
                $periods = floor($elapsedMinutes / $earning_duration);
                $incrementalEarnings = $periods * ($investment_amount * ($roi / 100));

                // Calculate total elapsed time since the investment started
                $totalElapsedMinutes = $created_at->diff($currentDateTime)->days * 24 * 60 + $elapsedMinutes;

                if ($totalElapsedMinutes >= $duration_timeframe * 24 * 60) {
                    // Finalize the investment
                    $finalEarnings = $total_earnings + $current_earnings + $incrementalEarnings;

                    // Update the investment status and total earnings
                    $updateQuery = "UPDATE investments SET total_earnings = ?, earnings = 0, status = 'completed', completed_at = ?, last_earning_time = ? WHERE investment_id = ?";
                    if ($stmtUpdate = $conn->prepare($updateQuery)) {
                        $completed_at = $currentDateTime->format('Y-m-d H:i:s');
                        $last_earning_time_str = $currentDateTime->format('Y-m-d H:i:s');
                        $stmtUpdate->bind_param("dssi", $finalEarnings, $completed_at, $last_earning_time_str, $investment_id);
                        $stmtUpdate->execute();
                        logMessage("Investment {$investment_id} completed. Total earnings: {$finalEarnings}");
                    }

                    // Update user balance
                    $userQuery = "SELECT balance FROM users WHERE user_id = ?";
                    if ($stmtUser = $conn->prepare($userQuery)) {
                        $stmtUser->bind_param("i", $user_id);
                        $stmtUser->execute();
                        $userResult = $stmtUser->get_result();
                        if ($user = $userResult->fetch_assoc()) {
                            // Calculate the new balance as the original investment + total earnings
                            $newBalance = $user['balance'] + $investment_amount + $finalEarnings;  // Add investment amount + earnings
                            $updateBalanceQuery = "UPDATE users SET balance = ? WHERE user_id = ?";
                            if ($stmtUpdateBalance = $conn->prepare($updateBalanceQuery)) {
                                $stmtUpdateBalance->bind_param("di", $newBalance, $user_id);
                                $stmtUpdateBalance->execute();
                                logMessage("User {$user_id}'s balance updated. New balance: {$newBalance}");

                                // Add transaction to the transactions table
                                $transaction_id = txn_time();
                                $totalTransactionAmount = $investment_amount + $finalEarnings; // Calculate the total amount
                                $transactionQuery = "INSERT INTO transactions (transaction_id, user_id, crypto_symbol, amount, transaction_type, wallet_address, status) 
                                                     VALUES (?, ?, ?, ?, 'deposit', 'earnings', 'completed')";
                                if ($stmtTransaction = $conn->prepare($transactionQuery)) {
                                    $stmtTransaction->bind_param("sisd", $transaction_id, $user_id, $crypto_symbol,$totalTransactionAmount);
                                    $stmtTransaction->execute();
                                    logMessage("Transaction added successfully. Transaction ID: {$transaction_id}, User ID: {$user_id}, Amount: {$totalTransactionAmount}, Crypto Symbol: {$crypto_symbol}");
                                    
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
                                            $mail->Subject = 'Investment Completed';
                                            $mail->Body = "
                                                <p>Dear {$userName},</p>
                                                <p>Congratulations! Your investment of <strong>{$investment_amount}</strong> in <strong>{$crypto_symbol}</strong> has been successfully completed.</p>
                                                <p>Your total earnings of <strong>{$finalEarnings}</strong> have been added to your balance and are now available for withdrawal.</p>
                                                <p>Thank you for investing with Simart Pro!</p>
                                            ";

                                            $mail->send();
                                            logMessage("Investment completion email sent to {$userEmail} for Transaction ID: {$transaction_id}");
                                        } catch (Exception $e) {
                                            error_log("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
                                        }
                                    }

                                    // Send investment completion notification
                                    $message = "Your investment of {$investment_amount} in {$crypto_symbol} has been completed. Your total earnings of {$finalEarnings} have been added to your balance.";
                                    $notificationQuery = "INSERT INTO notifications (user_id, message) VALUES (?, ?)";
                                    if ($stmtNotification = $conn->prepare($notificationQuery)) {
                                        $stmtNotification->bind_param("is", $user_id, $message);
                                        $stmtNotification->execute();
                                        logMessage("Investment completion notification sent to User ID: {$user_id}");
                                    }
                                } else {
                                    logMessage("Failed to add transaction for User ID: {$user_id}. Error: " . $conn->error);
                                }
                            }
                        }
                    }
                } else {
                    // Increment earnings and update last_earning_time
                    $newEarnings = $current_earnings + $incrementalEarnings;
                    $updateEarningsQuery = "UPDATE investments SET earnings = ?, last_earning_time = ? WHERE investment_id = ?";
                    if ($stmtUpdate = $conn->prepare($updateEarningsQuery)) {
                        $last_earning_time_str = $currentDateTime->format('Y-m-d H:i:s');
                        $stmtUpdate->bind_param("dsi", $newEarnings, $last_earning_time_str, $investment_id);
                        $stmtUpdate->execute();
                        logMessage("Investment {$investment_id} updated. Incremental earnings added: {$incrementalEarnings}, Total earnings: {$newEarnings}");
                    }
                }
            } else {
                logMessage("Investment {$investment_id}: Not enough time has elapsed for earnings to be added.");
            }
        }
    }
    $stmt->close();
}
$conn->close();
?>