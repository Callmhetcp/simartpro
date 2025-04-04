<?php
function checkAdminAccess() {
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
        header("Location: dashboard.php"); // Redirect unauthorized users
        exit();
    }
}
?>
