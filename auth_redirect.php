<?php
function redirectIfLoggedIn() {
    session_start(); // Start the session

    // Check if the user is logged in
    if (isset($_SESSION['user_id'])) {
        // Check if OTP is verified
        if (isset($_SESSION['otp_verified']) && $_SESSION['otp_verified'] === true) {
            // Redirect based on the user's role
            if ($_SESSION['user_role'] === 'user') {
                header("Location: dashboard.php"); // Redirect verified users to their dashboard
                exit();
            } elseif ($_SESSION['user_role'] === 'admin') {
                header("Location: admin_dashboard.php"); // Redirect verified admins to their dashboard
                exit();
            }
        } else {
            // If OTP is not verified, destroy the session and redirect to login.php
            $_SESSION = []; // Unset all session variables

            // If it's desired to kill the session, also delete the session cookie.
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }

            session_destroy(); // Destroy the session
            header("Location: login.php");
            exit();
        }
    }
}
?>

