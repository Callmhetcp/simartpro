<?php
include 'connection.php';
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the raw input data
    $data = json_decode(file_get_contents('php://input'), true);

    // Log the received data for debugging
    file_put_contents('log.txt', "Received data: " . print_r($data, true) . "\n", FILE_APPEND);

    $cryptoId = isset($data['crypto_id']) ? intval($data['crypto_id']) : 0;

    if ($cryptoId > 0) {
        // Prepare and execute the SQL query to delete the crypto
        $sql = "DELETE FROM cryptos WHERE crypto_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $cryptoId);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Crypto deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error deleting crypto']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid crypto ID']);
    }

    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
