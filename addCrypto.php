<?php
include 'connection.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the JSON data from the request
    $data = json_decode(file_get_contents('php://input'), true);

    // Validate and sanitize input
    $card_id = isset($data['card_id']) ? intval($data['card_id']) : 0;
    $crypto_name = isset($data['crypto_name']) ? trim($data['crypto_name']) : '';
    $symbol = isset($data['symbol']) ? trim($data['symbol']) : '';

    // Check if the required data is provided
    if ($card_id > 0 && !empty($crypto_name) && !empty($symbol)) {
        // Start a database transaction
        $conn->begin_transaction();

        try {
            // Insert or update the crypto in the Cryptos table
            $sql = "INSERT INTO cryptos (crypto_name, symbol) 
                    VALUES (?, ?)
                    ON DUPLICATE KEY UPDATE crypto_id = LAST_INSERT_ID(crypto_id)";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                throw new Exception('Error preparing the crypto insertion query.');
            }

            $stmt->bind_param('ss', $crypto_name, $symbol);
            if (!$stmt->execute()) {
                throw new Exception('Error inserting/updating crypto: ' . $stmt->error);
            }

            // Get the crypto_id of the inserted or updated row
            $crypto_id = $stmt->insert_id;
            $stmt->close();

            // Associate the crypto with the investment card in the Investment_Card_Cryptos table
            $sql2 = "INSERT INTO investment_card_cryptos (card_id, crypto_id) 
                     VALUES (?, ?)";
            $stmt2 = $conn->prepare($sql2);
            if (!$stmt2) {
                throw new Exception('Error preparing the association query.');
            }

            $stmt2->bind_param('ii', $card_id, $crypto_id);
            if (!$stmt2->execute()) {
                throw new Exception('Error linking crypto to investment card: ' . $stmt2->error);
            }

            $stmt2->close();

            // Commit the transaction
            $conn->commit();

            // Return a success response
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            // Rollback the transaction in case of an error
            $conn->rollback();

            // Return an error response
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid card ID or missing data.']);
    }

    // Close the database connection
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
