<?php
include 'connection.php';
header('Content-Type: application/json'); // Set the response type to JSON

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$response = array();

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get the plan ID from the POST request
        if (isset($_POST['plan_id'])) {
            $plan_id = $_POST['plan_id'];

            // Query to delete the plan from the database
            $query = "DELETE FROM investment_plan WHERE id = ?";

            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("i", $plan_id);

                if ($stmt->execute()) {
                    $response['success'] = true;
                    $response['message'] = 'Investment plan deleted successfully!';
                } else {
                    $response['success'] = false;
                    $response['message'] = $stmt->error;
                }
                $stmt->close();
            } else {
                $response['success'] = false;
                $response['message'] = $conn->error;
            }
        } else {
            $response['success'] = false;
            $response['message'] = 'Plan ID is required.';
        }
    } else {
        $response['success'] = false;
        $response['message'] = 'Invalid request method.';
    }
} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = $e->getMessage();
}

// Return the JSON response
echo json_encode($response);
?>
