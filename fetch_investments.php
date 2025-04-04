<?php
// Include database connection
require_once 'connection.php'; // Ensure this file establishes $conn as the database connection
session_start();

// Redirect to login if the session is not set
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Fetch the investments from the database (no need for user_id anymore)
$sql = "SELECT card_id, investment_name FROM investment_cards";
$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->bind_result($cardId, $investmentName);

$investments = [];
while ($stmt->fetch()) {
    $investments[] = [
        'card_id' => $cardId,
        'investment_name' => $investmentName
    ];
}

$stmt->close();
$conn->close();

// Return the investments as JSON
echo json_encode(['success' => true, 'investments' => $investments]);
?>
