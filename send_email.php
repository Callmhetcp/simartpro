<?php
include 'connection.php'; // Database connection

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer autoload
require 'vendor/autoload.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user ID and the content of the email
    $userId = $_POST['user_id'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Query to get the user's email from the database
    $query = "SELECT email FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $userEmail = $user['email'];

        // Send the email using PHPMailer
        $mail = new PHPMailer(true);
        
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'server305.web-hosting.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'support@simartpro.com'; // SMTP username
            $mail->Password = 'simartpro.com';         // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('support@simartpro.com', 'Admin');
            $mail->addAddress($userEmail);

            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = "
<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>{$subject}</title>
    <style>
        body { font-family: Arial, sans-serif; color: #333; background: #f9f9f9; }
        .container { width: 100%; max-width: 500px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; border: 1px solid #ddd; }
        .otp { font-size: 24px; font-weight: bold; background: #f4f4f4; padding: 10px; border-radius: 4px; display: inline-block; }
        .footer { font-size: 12px; color: #777; margin-top: 20px; text-align: center; }
    </style>
</head>
<body>
    <div class='container'>
        " . nl2br(htmlspecialchars($message)) . "
        <hr>
        <p class='footer'>This is an official email from Simart Pro. If you have any questions or need assistance, please contact our support team.</p>
    </div>
</body>
</html>";

            // Handle attachment
            if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
                $mail->addAttachment($_FILES['attachment']['tmp_name'], $_FILES['attachment']['name']);
            }

            // Send email
            $mail->send();
            $toastMessage = 'Message has been sent';
        } catch (Exception $e) {
            $toastMessage = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        $toastMessage = 'User email not found.';
    }

    // JavaScript to display the alert and redirect
    echo "<script>
            alert('$toastMessage');
            window.location.href = 'users.php'; // Redirect to users.php
          </script>";
}
?>
