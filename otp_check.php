<?php


// Check if OTP is verified
if (!isset($_SESSION['otp_verified']) || $_SESSION['otp_verified'] !== true) {
    // Redirect to OTP verification page
    header('Location: verify_otp.php');
    exit();
}
?>
