<?php
// Include the database connection file
include 'connection.php';

// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the posted user ID and new status
    $user_id = intval($_POST['user_id']);
    $new_status = $_POST['status'] === 'enabled' ? 'enabled' : 'disabled'; // Sanitize status

    // Prepare the SQL query to update the user's status
    $update_query = "UPDATE users SET status = ? WHERE user_id = ?";

    if ($stmt = $conn->prepare($update_query)) {
        // Bind parameters (status as string, user_id as integer)
        $stmt->bind_param("si", $new_status, $user_id);

        // Execute the query
        if ($stmt->execute()) {
            // Success: Now retrieve the updated status using a SELECT query
            $select_query = "SELECT status FROM users WHERE user_id = ?";

            if ($select_stmt = $conn->prepare($select_query)) {
                // Bind the user ID parameter for the SELECT query
                $select_stmt->bind_param("i", $user_id);
                
                // Execute the SELECT query
                $select_stmt->execute();
                
                // Bind the result variable to the prepared statement
                $select_stmt->bind_result($status);
                
                // Fetch the result (this will set the $status variable)
                if ($select_stmt->fetch()) {
                    // Return the updated status
                    echo json_encode([
                        'success' => true,
                        'current_status' => $status
                    ]);
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Failed to retrieve updated status.'
                    ]);
                }

                // Close the SELECT statement
                $select_stmt->close();
            }
        } else {
            // Failure to update the status
            echo json_encode([
                'success' => false,
                'message' => 'Failed to update the status.'
            ]);
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        // Query preparation failed
        echo json_encode([
            'success' => false,
            'message' => 'Error preparing the update query.'
        ]);
    }
} else {
    // Invalid request method
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method.'
    ]);
}

// Close the database connection
$conn->close();
?>
