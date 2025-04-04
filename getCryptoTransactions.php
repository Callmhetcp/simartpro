<?php
include 'connection.php';
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}

// Get the logged-in user's ID from session
$userId = $_SESSION['user_id'];

// Check if a crypto symbol is provided
$data = json_decode(file_get_contents('php://input'), true);
$cryptoSymbol = isset($data['crypto_symbol']) ? trim($data['crypto_symbol']) : '';

// If the crypto symbol is provided, get the available balance for it
if (!empty($cryptoSymbol)) {
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

    // Return the available balance for the selected crypto
    echo json_encode([
        'success' => true,
        'crypto_symbol' => $cryptoSymbol,
        'available_balance' => $availableBalance,
    ]);
    exit;
}

// If no crypto symbol is provided, fetch all available crypto symbols for the user
$query = "SELECT DISTINCT crypto_symbol FROM transactions WHERE user_id = ? AND status = 'completed'";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $userId);
$stmt->execute();
$result = $stmt->get_result();

// Prepare the list of available crypto symbols
$cryptos = [];
while ($row = $result->fetch_assoc()) {
    $cryptos[] = [
        'symbol' => $row['crypto_symbol'],
    ];
}

// Close the statement
$stmt->close();

// Return the list of available crypto symbols for the user
echo json_encode([
    'success' => true,
    'cryptos' => $cryptos,
]);
?>
