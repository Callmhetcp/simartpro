<?php
include 'connection.php';

$logFile = 'log.txt'; // Specify the path to your log file

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve inputs from the POST request
    $cryptoId = $_POST['crypto_id'] ?? '';
    $address = $_POST['payment_method_address'] ?? '';
    $network = $_POST['payment_method_network'] ?? '';
    $qrCodeFile = $_FILES['qr_code_input'] ?? null;

    // Validation: Ensure all required fields are present
    if (empty($cryptoId) || empty($address) || empty($network)) {
        $errorMessage = "Crypto ID, Address, and Network are required.";
        echo $errorMessage;
        error_log($errorMessage, 3, $logFile);
        exit;
    }

    // Initialize QR code path variable
    $qrCodePath = null;

    // Handle QR code file upload if provided
    if (!empty($qrCodeFile['name'])) {
        $targetDir = "qr_code/";
        $fileName = basename($qrCodeFile["name"]);
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($qrCodeFile["tmp_name"], $targetFilePath)) {
            $qrCodePath = $targetFilePath;
        } else {
            $errorMessage = "Failed to upload QR code.";
            echo $errorMessage;
            error_log($errorMessage, 3, $logFile);
            exit;
        }
    }

    // Prepare the SQL query to update the wallet info
    $query = "
        UPDATE crypto_wallets 
        SET address = ?, 
            network = ?, 
            qr_code_path = COALESCE(?, qr_code_path)
        WHERE id = ?
    ";
    
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        $errorMessage = "Failed to prepare the query: " . $conn->error;
        echo $errorMessage;
        error_log($errorMessage, 3, $logFile);
        exit;
    }

    // Bind parameters to the query
    $stmt->bind_param("ssss", $address, $network, $qrCodePath, $cryptoId);

    // Execute the query and handle the result
    if ($stmt->execute()) {
        $successMessage = "Wallet info updated successfully!";
        echo $successMessage;
        error_log($successMessage, 3, $logFile);
    } else {
        $errorMessage = "Database error: " . $conn->error;
        echo $errorMessage;
        error_log($errorMessage, 3, $logFile);
    }

    $stmt->close();
}

$conn->close();
?>
