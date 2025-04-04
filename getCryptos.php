<?php
include 'connection.php'; // Include your database connection

session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the JSON data from the request
    $data = json_decode(file_get_contents('php://input'), true);

    // Sanitize input and check for valid card_id
    $card_id = isset($data['card_id']) ? intval($data['card_id']) : 0;

    // If card_id is valid, fetch associated cryptocurrencies
    if ($card_id > 0) {
        $sql = "SELECT c.crypto_id, c.crypto_name, c.symbol 
                FROM cryptos c
                JOIN investment_card_cryptos icc ON c.crypto_id = icc.crypto_id
                WHERE icc.card_id = ?";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param('i', $card_id);
            $stmt->execute();
            $result = $stmt->get_result();

            // Prepare the list of cryptos
            $cryptos = [];
            while ($row = $result->fetch_assoc()) {
                $cryptos[] = $row;
            }

            // Respond with the list of cryptos
            echo json_encode(['success' => true, 'cryptos' => $cryptos]);
            $stmt->close();
        } else {
            // Error preparing the SQL statement
            echo json_encode(['success' => false, 'message' => 'Error preparing query.']);
        }
    } else {
        // Invalid card_id
        echo json_encode(['success' => false, 'message' => 'Invalid card ID.']);
    }

    // Close the database connection
    $conn->close();
} else {
    // Invalid request method
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
