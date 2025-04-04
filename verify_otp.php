<?php
session_start();
require 'connection.php'; // Include your database connection

header('Content-Type: application/json');

$response = ['success' => false, 'message' => 'Invalid or expired OTP.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $otp = mysqli_real_escape_string($conn, $_POST['otp']);

    // Verify OTP
    $query = "SELECT * FROM otps WHERE user_email = '$email' AND otp_code = '$otp' AND expires_at > NOW()";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        // Mark OTP as verified
        $_SESSION['otp_verified'] = true;
        $response['success'] = true;
        $response['message'] = 'OTP verified successfully.';
    } else {
        // Ensure OTP is not verified and redirect to login
        $_SESSION['otp_verified'] = false;
        $response['message'] = 'Invalid or expired OTP. Redirecting to login...';
    }
}

// If OTP not verified, redirect to login.php
if (!$_SESSION['otp_verified']) {
    header('Location: login.php');
    exit();
}

echo json_encode($response);
?>

