<?php
include 'connection.php';
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}

// Get the raw input data and decode it
$data = json_decode(file_get_contents('php://input'), true);

// Extract and sanitize the input data
$cryptoId = isset($data['crypto_id']) ? $data['crypto_id'] : '';
$cryptoName = isset($data['crypto_name']) ? trim($data['crypto_name']) : '';
$symbol = isset($data['symbol']) ? trim($data['symbol']) : '';

// Validate the inputs
if (empty($cryptoId) || empty($cryptoName) || empty($symbol)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit;
}

// Prepare and execute the SQL query to update the cryptocurrency
$query = "UPDATE cryptos SET crypto_name = ?, symbol = ? WHERE crypto_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('ssi', $cryptoName, $symbol, $cryptoId);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Crypto updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error updating crypto']);
}

$stmt->close();
$conn->close();
?>
