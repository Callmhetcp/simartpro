<?php
session_start(); // Start the session

// Include the database connection
require 'connection.php';

// Include PHPMailer classes using Composer's autoloader
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include Composer's autoloader
require 'vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])) {
    // Sanitize and fetch the email input
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // Check if the email exists in the database
    $stmt = $conn->prepare("SELECT firstname FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        die("Email not found. Please check and try again.");
    }

    // Fetch the user's first name
    $user = $result->fetch_assoc();
    $firstname = $user['firstname'];

    // Generate a new strong random password
    $new_password = bin2hex(random_bytes(4)) . random_int(1000, 9999); // e.g., "8f1a3c471234"

    // Hash the new password
    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

    // Update the password in the database
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $hashed_password, $email);
    if ($stmt->execute()) {
        // Send the new password to the user's email
        sendResetPasswordEmail($email, $firstname, $new_password);
        echo "<script>alert('A new password has been sent to your email.');</script>";
    } else {
         echo "<script>alert('Failed to reset password. Please try again.');</script>";
    }

    $stmt->close();
}

// Function to send the reset password email using PHPMailer
function sendResetPasswordEmail($email, $firstname, $new_password)
{
    // Create a new PHPMailer instance
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
        $mail->addAddress($email, $firstname); // Send to the user's email address

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Your New Password';
        $mail->Body = "
            <p>Dear $firstname,</p>
            <p>As per your request, your password has been reset. Your new password is:</p>
            <h3>$new_password</h3>
            <p>Please log in using this password and change it immediately for security reasons.</p>
            <p>Thank you for choosing Simart Pro!</p>
        ";

        // Send the email
        $mail->send();
    } catch (Exception $e) {
        // Log error if email could not be sent
        error_log("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }
}
?>
