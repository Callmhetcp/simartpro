<?php
include 'connection.php';
session_start();

// Function to write logs to a log file
function logToFile($message) {
    $logFile = 'log.txt';
    $currentDateTime = date('Y-m-d H:i:s');
    $logMessage = "[$currentDateTime] - $message\n";
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    logToFile('Error: User not logged in.');
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;  // Exit here to stop further execution
}

// Get the logged-in user's ID from session
$userId = $_SESSION['user_id'];

// Get the cryptocurrency symbol from the request
$data = json_decode(file_get_contents('php://input'), true);
$cryptoSymbol = isset($data['crypto_symbol']) ? trim($data['crypto_symbol']) : '';

// If the crypto symbol is not provided, return an error
if (empty($cryptoSymbol)) {
    logToFile("Error: Crypto symbol is required.");
    echo json_encode(['success' => false, 'message' => 'Crypto symbol is required.']);
    exit;  // Exit here to stop further execution
}

// Log the received request
logToFile("Request received: user_id = $userId, crypto_symbol = $cryptoSymbol");

// Query to get the user's transactions for the requested crypto
$query = "SELECT transaction_type, amount FROM transactions WHERE user_id = ? AND crypto_symbol = ? AND status = 'completed'";
$stmt = $conn->prepare($query);
$stmt->bind_param('is', $userId, $cryptoSymbol);
$stmt->execute();
$result = $stmt->get_result();

// Sum the amounts for the requested crypto
$availableBalance = 0.0;
while ($row = $result->fetch_assoc()) {
    $amount = floatval($row['amount']); // Ensure the amount is a number
    $type = $row['transaction_type'];
    if ($type === 'Deposit') {
        $availableBalance += $amount; // Add deposits
    } elseif ($type === 'Withdrawal') {
        // Subtract withdrawals only if the balance is sufficient
        $availableBalance -= $amount;
    }
}

// Close the statement
$stmt->close();

// Ensure no negative balance
if ($availableBalance < 0) {
    $availableBalance = 0.0;
}

// Log the available balance
logToFile("Available balance for crypto_symbol ($cryptoSymbol): $availableBalance");

// Return the available balance for the selected crypto
echo json_encode([
    'success' => true,
    'crypto_symbol' => $cryptoSymbol,
    'available_balance' => $availableBalance,
]);

// Log the successful response
logToFile("Response sent: success = true, available_balance = $availableBalance");

// Exit after the response has been sent
exit;



