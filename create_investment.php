<?php
// Include database connection
require_once 'connection.php'; // Ensure this file establishes $conn as the database connection
session_start();

// Enable error reporting for debugging purposes
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Redirect to login if the session is not set
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

// Read the input data
$data = json_decode(file_get_contents('php://input'), true);

// Validate input
if (isset($data['action']) && $data['action'] === 'create_investment' && isset($data['name']) && !empty($data['name'])) {
    $investmentName = trim($data['name']); // Get the name of the investment

    try {
        // Prepare the SQL statement to insert the investment name
        $stmt = $conn->prepare("INSERT INTO investment_cards (investment_name) VALUES (?)");
        $stmt->bind_param("s", $investmentName); // Bind the investment name as a string

        // Execute the statement
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Investment card created successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error executing SQL: ' . $stmt->error]); // SQL execution error
        }

        $stmt->close(); // Close the prepared statement
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Exception: ' . $e->getMessage()]); // Handle any exceptions
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input data.']); // Invalid input handling
}

$conn->close(); // Close the database connection
?>
