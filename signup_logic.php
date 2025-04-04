<?php
// Start session
session_start();

// Include necessary files
require 'auth_redirect.php'; // Redirects logged-in users
redirectIfLoggedIn();
require 'connection.php'; // Database connection

// Include PHPMailer for email sending
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

// Handle signup form submission
if (isset($_POST['signup_btn'])) {
    signup();
}

/**
 * Signup Function (with IP blocking)
 */
function signup()
{
    global $conn;

    // Get user's IP address
    $user_ip = $_SERVER['REMOTE_ADDR'];

    // Check if IP has exceeded allowed attempts
    if (isIpBlocked($user_ip)) {
        die("Too many registration attempts from this IP. Please try again later.");
    }

    // Sanitize user input
    $firstname   = mysqli_real_escape_string($conn, $_POST['fname']);
    $lastname    = mysqli_real_escape_string($conn, $_POST['lname']);
    $email       = mysqli_real_escape_string($conn, $_POST['email']);
    $password    = mysqli_real_escape_string($conn, $_POST['password']);
    $dob         = mysqli_real_escape_string($conn, $_POST['dob']);
    $gender      = mysqli_real_escape_string($conn, $_POST['gender']);
    $nationality = mysqli_real_escape_string($conn, $_POST['nationality']);
    $state       = mysqli_real_escape_string($conn, $_POST['state']);
    $conf_pass   = mysqli_real_escape_string($conn, $_POST['conf_pass']);
    $phone       = mysqli_real_escape_string($conn, $_POST['phone']);

    // Check if passwords match
    if ($conf_pass !== $password) {
        $GLOBALS['ERROR'] = "Passwords do not match.";
        return;
    }

    // Check if email already exists
    if (isEmailExists($email)) {
        $GLOBALS['ERROR'] = "Email already in use!";
        return;
    }

    // Hash the password
    $hashedPwd = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

    // Generate a unique 6-digit user ID
    $user_id = generateUniqueUserId();

    // Insert user details into the database
    $insert = "INSERT INTO users (user_id, firstname, lastname, email, nationality, state, dob, gender, password, phone, role, email_verified) 
               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'user', 0)";
    $stmt = $conn->prepare($insert);
    $stmt->bind_param("isssssssss", $user_id, $firstname, $lastname, $email, $nationality, $state, $dob, $gender, $hashedPwd, $phone);

    if ($stmt->execute()) {
        // Store email in session
        $_SESSION['email'] = $email;

        // Generate and store OTP
        $otp = rand(100000, 999999);
        storeOtp($email, $otp);

        // Log the user's IP to prevent spam
        logUserIp($user_ip);

        // Send OTP email
        sendOtpEmail($email, $firstname, $otp);

        // Clean up expired OTPs
        deleteExpiredOtps();

        // Redirect to OTP verification page
        header('Location: otp_verification.php?msg=Signup success, please verify your email');
        exit();
    } else {
        $GLOBALS['ERROR'] = "Unexpected error, please try again.";
    }
    $stmt->close();
}

/** ================================
 * 🔹 IP BLOCKING & SECURITY FUNCTIONS
 * =================================
 */

/**
 * Check if IP is blocked due to excessive registrations.
 */
function isIpBlocked($ip)
{
    global $conn;
    $query = "SELECT COUNT(*) AS attempt_count FROM registration_attempts WHERE ip_address = ? AND attempt_time > (NOW() - INTERVAL 10 MINUTE)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $ip);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['attempt_count'] >= 3; // Block if more than 3 attempts in 10 mins
}

/**
 * Log user's IP for spam prevention.
 */
function logUserIp($ip)
{
    global $conn;
    $query = "INSERT INTO registration_attempts (ip_address, attempt_time) VALUES (?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $ip);
    $stmt->execute();
    $stmt->close();
}

/** ================================
 * 🔹 USER & EMAIL FUNCTIONS
 * =================================
 */

/**
 * Check if email is already registered.
 */
function isEmailExists($email)
{
    global $conn;
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    return $stmt->num_rows > 0;
}

/**
 * Generate a unique 6-digit user ID.
 */
function generateUniqueUserId()
{
    global $conn;
    do {
        $user_id = random_int(100000, 999999);
        $query = "SELECT * FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->store_result();
    } while ($stmt->num_rows > 0);
    return $user_id;
}

/** ================================
 * 🔹 OTP FUNCTIONS
 * =================================
 */

/**
 * Store OTP in the database.
 */
function storeOtp($email, $otp)
{
    global $conn;
    $query = "INSERT INTO otps (user_email, otp_code, expires_at) VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 2 MINUTE))";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $email, $otp);
    $stmt->execute();
}

/**
 * Delete expired OTPs.
 */
function deleteExpiredOtps()
{
    global $conn;
    $query = "DELETE FROM otps WHERE expires_at <= NOW()";
    mysqli_query($conn, $query);
}

/** ================================
 * 🔹 EMAIL SENDING FUNCTION
 * =================================
 */

/**
 * Send OTP email.
 */
function sendOtpEmail($email, $firstname, $otp)
{
    $mail = new PHPMailer(true);
    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'server305.web-hosting.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'support@simartpro.com'; // SMTP username
        $mail->Password = 'simartpro.com';         // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email details
        $mail->setFrom('support@simartpro.com', 'SimartPro Admin');
        $mail->addAddress($email, $firstname);
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP Code';
        $mail->Body = "
            <p>Dear $firstname,</p>
            <p>Thank you for signing up! Your OTP code is:</p>
            <h3>$otp</h3>
            <p>This OTP will expire in 2 minutes.</p>
            <p>Please use it to verify your email address.</p>
            <p>Thank you for choosing Simart Pro!</p>
        ";

        $mail->send();
    } catch (Exception $e) {
        error_log("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }
}
?>