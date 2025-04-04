<?php
include 'connection.php';
session_start();

// Function to write logs to a log file
function logToFile($message) {
    $logFile = 'log.txt';  // Path to your log file
    $currentDateTime = date('Y-m-d H:i:s');  // Current date and time
    $logMessage = "[$currentDateTime] - $message\n";  // Log message format
    file_put_contents($logFile, $logMessage, FILE_APPEND);  // Write to log file
}

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    logToFile('Error: User not logged in.');
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;  // Exit after sending the response
}

// Get the provided crypto_id from the request
$data = json_decode(file_get_contents('php://input'), true);
$cryptoId = isset($data['crypto_id']) ? trim($data['crypto_id']) : '';

// Log the received request
logToFile("Request received: user_id = {$_SESSION['user_id']}, crypto_id = $cryptoId");

// If no crypto_id is provided, return an error
if (empty($cryptoId)) {
    logToFile('Error: Crypto ID is required.');
    echo json_encode(['success' => false, 'message' => 'Crypto ID is required.']);
    exit;  // Exit after sending the response
}

// Query to get the crypto symbol from the cryptos table
$query = "SELECT symbol FROM cryptos WHERE crypto_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $cryptoId);
$stmt->execute();
$stmt->bind_result($cryptoSymbol);
$stmt->fetch();

// Close the statement
$stmt->close();

// If no crypto symbol is found, return an error
if (empty($cryptoSymbol)) {
    logToFile("Error: Crypto symbol not found for crypto_id = $cryptoId.");
    echo json_encode(['success' => false, 'message' => 'Crypto symbol not found.']);
    exit;  // Exit after sending the response
}

// Log the successful response
logToFile("Success: Crypto symbol found: $cryptoSymbol for crypto_id = $cryptoId.");

// Return the crypto symbol
echo json_encode([
    'success' => true,
    'symbol' => $cryptoSymbol,
]);

// Exit after sending the response
exit;
?>
