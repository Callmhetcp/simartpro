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
        // Capture raw POST data
        $rawPostData = file_get_contents('php://input');
        
        // Log raw POST data to log.txt
        file_put_contents('log.txt', "Raw POST Data:\n" . $rawPostData . "\n\n", FILE_APPEND);

        // Parse form-encoded data
        $plan_id = $_POST['plan_id']; // Get plan ID
        $crypto_id = $_POST['crypto_id']; // Get crypto ID
        $name = $_POST['name'];
        $roi = $_POST['roi'];
        $roi_max = $_POST['roi_max'];
        $minimum = $_POST['minimum'];
        $maximum = $_POST['maximum'];
        $earning_duration = $_POST['earning_duration'];
        $duration_timeframe = $_POST['duration_timeframe'];
        $duration = $_POST['duration'];
        $commission = $_POST['commission'];
        $benefit = $_POST['benefit'];

        // Log parsed form data
        file_put_contents(
            'log.txt',
            "Parsed Form Data:\n" . print_r($_POST, true) . "\n\n",
            FILE_APPEND
        );

        // Query for updating the investment plan using plan_id and crypto_id
        $query = "UPDATE investment_plan SET name=?, roi=?, roi_max=?, minimum=?, maximum=?, earning_duration=?, duration_timeframe=?, duration=?, commission=?, benefit=? WHERE id=? AND crypto_id=?";

        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("ssssssssssii", $name, $roi, $roi_max, $minimum, $maximum, $earning_duration, $duration_timeframe, $duration, $commission, $benefit, $plan_id, $crypto_id);

            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = 'Investment plan updated successfully!';
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
        $response['message'] = 'Invalid request method.';
    }
} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = $e->getMessage();
}

// Log response
file_put_contents('log.txt', "Response:\n" . json_encode($response) . "\n\n", FILE_APPEND);

// Return the JSON response
echo json_encode($response);
?>
