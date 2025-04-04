<?php
require_once 'connection.php';
$data = json_decode(file_get_contents('php://input'), true);

// Check if the 'id' is provided and valid
if (isset($data['id'])) {
    $id = intval($data['id']); // Ensure the ID is an integer

    try {
        // Prepare the DELETE SQL statement
        $stmt = $conn->prepare("DELETE FROM investment_cards WHERE card_id = ?");
        $stmt->bind_param('i', $id); // Bind the parameter (integer for id)

        // Execute the DELETE query
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Investment deleted successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database delete failed.']);
        }

        // Close the prepared statement
        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    // If the 'id' is missing or invalid
    echo json_encode(['success' => false, 'message' => 'Invalid input.']);
}

// Close the database connection
$conn->close();
?>
