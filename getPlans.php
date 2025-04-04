<?php
include 'connection.php';

// Decode the incoming JSON request
$data = json_decode(file_get_contents('php://input'), true);
$crypto_id = $data['crypto_id'];  // Get the selected crypto_id

// Prepare SQL statement to fetch plans for the selected crypto
$sql = "SELECT * FROM investment_plan WHERE crypto_id = ?";
$stmt = $conn->prepare($sql);

// Bind the parameter and execute
$stmt->bind_param("i", $crypto_id);
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Check if there are any plans
if ($result->num_rows > 0) {
    $plans = [];
    while ($row = $result->fetch_assoc()) {
        $plans[] = $row;
    }
    echo json_encode([
        'success' => true,
        'plans' => $plans
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'No plans available for this crypto.'
    ]);
}

$stmt->close();
$conn->close();
?>
