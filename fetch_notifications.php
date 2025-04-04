<?php
// Include the database connection
include('connection.php');

// Start session to fetch the logged-in user's ID
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'User not logged in.']);
    exit;
}

$userId = $_SESSION['user_id']; // Get the user ID from session

// Set headers for JSON response
header('Content-Type: application/json');

// Query to fetch unread notifications for the logged-in user
$query = "SELECT * FROM notifications WHERE user_id = ? AND status = 'unread' ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $userId); // Bind the user ID to the query
$stmt->execute();
$result = $stmt->get_result();

// Initialize an array to hold notifications
$notifications = [];

while ($row = $result->fetch_assoc()) {
    $notifications[] = [
        'id' => $row['id'],
        'message' => $row['message'],
        'status' => $row['status'],
        'created_at' => $row['created_at']
    ];
}

// Respond with the notifications in JSON format
echo json_encode(['success' => true, 'notifications' => $notifications]);

// Close the database connection
mysqli_close($conn);
?>
