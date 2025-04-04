<?php
include 'connection.php';
header('Content-Type: application/json'); // Set the response type to JSON

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect and validate input data
    $crypto_id = filter_input(INPUT_POST, 'crypto_id', FILTER_VALIDATE_INT);
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $roi = filter_input(INPUT_POST, 'roi', FILTER_VALIDATE_FLOAT);
    $roi_max = filter_input(INPUT_POST, 'roi_max', FILTER_VALIDATE_FLOAT);
    $minimum = filter_input(INPUT_POST, 'minimum', FILTER_VALIDATE_FLOAT);
    $maximum = filter_input(INPUT_POST, 'maximum', FILTER_VALIDATE_FLOAT);
    $earning_duration = filter_input(INPUT_POST, 'earning_duration', FILTER_VALIDATE_INT);
    $duration_timeframe = filter_input(INPUT_POST, 'duration_timeframe', FILTER_SANITIZE_STRING);
    $duration = filter_input(INPUT_POST, 'duration', FILTER_VALIDATE_INT);
    $commission = filter_input(INPUT_POST, 'commission', FILTER_VALIDATE_FLOAT);
    $benefit = filter_input(INPUT_POST, 'benefit', FILTER_SANITIZE_STRING);

    // Validate required fields
    if (!$crypto_id || !$name || !$roi || !$roi_max || !$minimum || !$maximum || !$earning_duration || !$duration_timeframe || !$duration || !$commission || !$benefit) {
        echo json_encode(['success' => false, 'message' => 'Invalid input. Please fill all fields.']);
        exit;
    }

    $query = "INSERT INTO investment_plan (crypto_id, name, roi, roi_max, minimum, maximum, earning_duration, duration_timeframe, duration, commission, benefit)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("isddddidsds", $crypto_id, $name, $roi, $roi_max, $minimum, $maximum, $earning_duration, $duration_timeframe, $duration, $commission, $benefit);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Investment plan added successfully!']);
        } else {
            // Log the error instead of exposing it
            error_log("MySQL Error: " . $stmt->error);
            echo json_encode(['success' => false, 'message' => 'Failed to add the investment plan.']);
        }
        $stmt->close();
    } else {
        // Log the error instead of exposing it
        error_log("MySQL Error: " . $conn->error);
        echo json_encode(['success' => false, 'message' => 'Failed to prepare the query.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
