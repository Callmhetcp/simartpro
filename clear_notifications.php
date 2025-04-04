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

// Query to update the status of all notifications for the logged-in user to 'read'
$query = "UPDATE notifications SET status = 'read' WHERE user_id = ?";
$stmt = $conn->prepare($query);

// Check if the query is prepared successfully
if ($stmt === false) {
    echo json_encode(['success' => false, 'error' => 'Failed to prepare the query.']);
    exit;
}

// Bind the user ID to the query
$stmt->bind_param('i', $userId);

// Execute the query
if ($stmt->execute()) {
    // Respond with a success message
    echo json_encode(['success' => true, 'message' => 'Notifications cleared.']);
} else {
    // Respond with an error if the query fails
    echo json_encode(['success' => false, 'error' => 'Failed to clear notifications.']);
}

// Close the database connection
mysqli_close($conn);
?>
