<?php
require_once 'connection.php';
$data = json_decode(file_get_contents('php://input'), true);

// Check if 'id' and 'new_name' are provided in the request and 'new_name' is not empty
if (isset($data['id'], $data['new_name']) && !empty($data['new_name'])) {
    $id = intval($data['id']); // Ensure the ID is an integer
    $newName = trim($data['new_name']); // Trim the new name

    try {
        // Prepare the update SQL statement
        $stmt = $conn->prepare("UPDATE investment_cards SET investment_name = ? WHERE card_id = ?");
        $stmt->bind_param('si', $newName, $id); // Bind the parameters (string for new name, integer for id)

        // Execute the statement
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Investment updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database update failed.']);
        }

        // Close the prepared statement
        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    // If the input is invalid
    echo json_encode(['success' => false, 'message' => 'Invalid input.']);
}

// Close the database connection
$conn->close();
?>

