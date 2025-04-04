<?php
// Start the session
session_start();

// Include necessary files and libraries
require 'auth_redirect.php';  // Redirect logged-in users
redirectIfLoggedIn();

require 'connection.php';     // Database connection

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php'; // Composer autoloader for PHPMailer

// Initialize error variable
$GLOBALS['ERROR'] = '';

// Handle login form submission
if (isset($_POST['signin_btn'])) {
    login();
}

/**
 * Login Function
 */
function login()
{
    global $conn;

    // Sanitize user input
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query the database for the user
    $select = "SELECT * FROM users WHERE email = '$email'";
    $sql = mysqli_query($conn, $select);

    if (mysqli_num_rows($sql) > 0) {
        $fetch = mysqli_fetch_assoc($sql);

        // Check if the account is disabled
        if ($fetch['status'] === 'Disabled') {
            $GLOBALS['ERROR'] = 'Your account is disabled. Please contact support.';
            return;
        }

        // Verify the password
        $storedPassword = $fetch['password'];
        $isPasswordCorrect = password_verify($password, $storedPassword);

        // If the password is plain text, hash it and update the database
        if (!$isPasswordCorrect && $password === $storedPassword) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $updateQuery = "UPDATE users SET password = '$hashedPassword' WHERE email = '$email'";
            mysqli_query($conn, $updateQuery);
            $isPasswordCorrect = true;
        }

        // Handle successful login
        if ($isPasswordCorrect) {
            handleLoginSuccess($fetch);
        } else {
            $GLOBALS['ERROR'] = 'Invalid login details.';
        }
    } else {
        $GLOBALS['ERROR'] = 'Invalid login details.';
    }

    // Delete expired OTPs
    deleteExpiredOtps();
}

/**
 * Handle Successful Login
 */
function handleLoginSuccess($fetch)
{
    global $conn;

    // Fetch user details
    $id = $fetch['user_id'];
    $name = $fetch['lastname'];
    $name2 = $fetch['firstname'];
    $email = $fetch['email'];
    $role = $fetch['role'];
    $dob = $fetch['dob'];
    $gender = $fetch['gender'];
    $nationality = $fetch['nationality'];
    $state = $fetch['state'];
    $phone = $fetch['phone'];

    if ($role !== 'admin') {
        // Generate OTP and set expiration time
        $otp = rand(100000, 999999);
        $insertOtp = "
            INSERT INTO otps (user_email, otp_code, expires_at) 
            VALUES ('$email', '$otp', DATE_ADD(NOW(), INTERVAL 2 MINUTE))
        ";
        mysqli_query($conn, $insertOtp);

        // Send OTP email
        sendOtpEmail($email, $name2, $otp);
    }

    // Store user details in session
    $_SESSION['user_id'] = $id;
    $_SESSION['user_firstname'] = $name;
    $_SESSION['user_lastname'] = $name2;
    $_SESSION['email'] = $email;
    $_SESSION['user_role'] = $role;
    $_SESSION['user_dob'] = $dob;
    $_SESSION['user_gender'] = $gender;
    $_SESSION['user_nationality'] = $nationality;
    $_SESSION['user_state'] = $state;
    $_SESSION['user_phone'] = $phone;

    // Redirect based on role
    if ($role === 'admin') {
        header('Location: admin_dashboard.php');
        exit();
    } else {
        header('Location: otp_verification_login.php');
        exit();
    }
}

/**
 * Delete Expired OTPs
 */
function deleteExpiredOtps()
{
    global $conn;

    // Use database time (NOW()) to delete expired OTPs
    $deleteQuery = "DELETE FROM otps WHERE expires_at <= NOW()";
    mysqli_query($conn, $deleteQuery);
}

/**
 * Send OTP Email
 */
function sendOtpEmail($email, $firstname, $otp)
{
    $mail = new PHPMailer(true);

    try {
        // SMTP server configuration
        $mail->isSMTP();
        $mail->Host = 'server305.web-hosting.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'support@simartpro.com'; // SMTP username
        $mail->Password = 'simartpro.com';         // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email settings
        $mail->setFrom('support@simartpro.com', 'SimartPro Admin');
        $mail->addAddress($email, $firstname);
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP Code';
        $mail->Body = "
            <!DOCTYPE html>
    <html>
    <head>
        <meta charset='UTF-8'>
        <title>Login Verification</title>
        <style>
            body { font-family: Arial, sans-serif; color: #333; background: #f9f9f9; }
            .container { width: 100%; max-width: 500px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; border: 1px solid #ddd; }
            .otp { font-size: 24px; font-weight: bold; background: #f4f4f4; padding: 10px; border-radius: 4px; display: inline-block; }
            .footer { font-size: 12px; color: #777; margin-top: 20px; text-align: center; }
        </style>
    </head>
    <body>
        <div class='container'>
            <p>Dear <strong>" . htmlspecialchars($firstname) . "</strong>,</p>
            <p>Thank you for logging in! To complete your login process, please use the One-Time Password (OTP) below:</p>
            <p class='otp'>" . htmlspecialchars($otp) . "</p>
            <p>This OTP will expire in <strong>2 minutes</strong>. Please use it to verify your login.</p>
            <p>If you did not request this login, please disregard this message.</p>
            <p>For any questions, contact our support team.</p>
            <p>Thank you for choosing <strong>Simart Pro!</strong></p>
            <hr>
            <p class='footer'>You are receiving this email because a login attempt was made on your account. If this wasn't you, please contact support.</p>
        </div>
    </body>
    </html>
    ";
        $mail->send();
    } catch (Exception $e) {
        // Log error if the email could not be sent
        error_log("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }
}
?>
