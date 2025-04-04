<?php
// Start the session to access session variables
session_start();
include 'connection.php';
header('Content-Type: application/json');

// Log function to write messages to log.txt
function logMessage($message) {
    $logFile = 'log.txt';  // Define the log file path
    $currentDateTime = date('Y-m-d H:i:s');  // Get the current date and time
    $logMessage = "[{$currentDateTime}] {$message}\n";  // Format the log message
    file_put_contents($logFile, $logMessage, FILE_APPEND);  // Append the log message to the file
}

// Get the plan_id from the POST request
$data = json_decode(file_get_contents('php://input'), true);
$plan_id = $data['plan_id'];

// Log the received plan_id
logMessage("Received request for investment plan with plan_id: {$plan_id}");

// Query to get the investment plan details based on plan_id
$query = "SELECT * FROM investment_plan WHERE id = ?";

if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("i", $plan_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the plan details
        $plan = $result->fetch_assoc();

        // Log the success of the query
        logMessage("Investment plan found. Plan details: " . json_encode($plan));

        // Return the plan details (including min and max investment)
        echo json_encode(['success' => true, 'plan' => $plan]);
    } else {
        // If the plan is not found
        logMessage("No investment plan found for plan_id: {$plan_id}");

        echo json_encode(['success' => false, 'message' => 'Investment plan not found.']);
    }

    $stmt->close();
} else {
    // If there's an error executing the query
    logMessage("Error preparing the query for plan_id: {$plan_id}");

    echo json_encode(['success' => false, 'message' => 'Error fetching investment plan details.']);
}
?>
