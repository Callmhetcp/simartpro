<?php
include "connection.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $message = htmlspecialchars($_POST['message']);

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();                                        // Use SMTP
        $mail->Host = 'server305.web-hosting.com';              // Set SMTP server
        $mail->SMTPAuth = true;                                 // Enable SMTP authentication
        $mail->Username = 'support@simartpro.com';              // SMTP username
        $mail->Password = 'simartpro.com';                      // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;     // Enable STARTTLS encryption
        $mail->Port = 587;                                      // TCP port

        // Recipients
        $mail->setFrom('support@simartpro.com', 'SimartPro Admin'); // Sender email and name
        $mail->addAddress('support@simartpro.com', 'Support Team'); // Recipient email and name

        // Email content
        $mail->isHTML(true);                                    // Set email format to HTML
        $mail->Subject = 'New Contact Form Submission';
        $mail->Body = "
            <h2>Contact Form Submission</h2>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>Message:</strong></p>
            <p>$message</p>
        ";

        // Send the email
        $mail->send();
        echo "<script>alert('Message sent successfully.'); window.location.href = 'index.php';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}'); window.location.href = 'index.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.location.href = 'index.php';</script>";
}
