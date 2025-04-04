<?php
require 'connection.php'; // Include your database connection

// Include PHPMailer classes using Composer's autoloader
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include Composer's autoloader
require 'vendor/autoload.php';

session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set the content type to JSON
header('Content-Type: application/json');

$response = ['success' => false, 'message' => 'Failed to resend OTP.'];

// Log session to ensure email is set
error_log("Session Email: " . ($_SESSION['email'] ?? 'Not set'));

// Ensure POST request and session email exist
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['email'])) {
    $email = mysqli_real_escape_string($conn, $_SESSION['email']); // Use session email

    // Check if the user exists
    $query = "SELECT firstname FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (!$result || mysqli_num_rows($result) === 0) {
        $response['message'] = 'Email not found in the system.';
        logResponse($response); // Log the response
        echo json_encode($response);
        exit();
    }

    $user = mysqli_fetch_assoc($result);
    $firstname = $user['firstname'];

    // Invalidate old OTPs by setting their expiration to NOW()
    $invalidateOldOtpsQuery = "UPDATE otps SET expires_at = NOW() WHERE user_email = '$email' AND expires_at > NOW()";
    mysqli_query($conn, $invalidateOldOtpsQuery);

    // Generate a new OTP
    $otp = rand(100000, 999999);

    // Insert the new OTP with a 2-minute expiration using database time
    $insertOtpQuery = "
        INSERT INTO otps (user_email, otp_code, expires_at, created_at) 
        VALUES ('$email', '$otp', DATE_ADD(NOW(), INTERVAL 2 MINUTE), NOW())";
    
    if (mysqli_query($conn, $insertOtpQuery)) {
        try {
            // Send the OTP email
            sendOtpEmail($email, $firstname, $otp);
            $response['success'] = true;
            $response['message'] = 'A new OTP has been sent to your email.';
        } catch (Exception $e) {
            $response['message'] = 'Failed to send the OTP email. Please try again later.';
        }
    } else {
        $response['message'] = 'Failed to update OTP. Please try again.';
    }
} else {
    $response['message'] = 'Invalid request or session email not set.';
}

// Log the final response
logResponse($response);

// Output the response as JSON
echo json_encode($response);

/**
 * Function to log the response
 */
function logResponse($response) {
    error_log("Response: " . json_encode($response), 3, 'log.txt');
}

/**
 * Function to send OTP email using PHPMailer
 */
function sendOtpEmail($email, $firstname, $otp)
{
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'server305.web-hosting.com'; // SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'support@simartpro.com'; // SMTP username
        $mail->Password = 'simartpro.com';        // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('support@simartpro.com', 'SimartPro Admin');
        $mail->addAddress($email, $firstname);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP Code';
        $mail->Body = "
            <p>Dear $firstname,</p>
            <p>Your OTP code is:</p>
            <h3>$otp</h3>
            <p>This OTP will expire in 2 minutes.</p>
            <p>Please use it promptly to verify your email address.</p>
        ";

        // Send the email
        $mail->send();
    } catch (Exception $e) {
        throw new Exception("Failed to send OTP email.");
    }
}
?>
