<?php
include 'connection.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : null;
    $status = isset($_POST['status']) ? htmlspecialchars($_POST['status']) : null;

    if ($user_id && ($status === 'enabled' || $status === 'disabled')) {
        $stmt = $conn->prepare("UPDATE users SET status = ? WHERE user_id = ?");
        $stmt->bind_param('si', $status, $user_id);


        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'User status updated successfully.';
        } else {
            $response['message'] = 'Failed to update user status.';
        }

        $stmt->close();
    } else {
        $response['message'] = 'Invalid input data.';
    }
}

echo json_encode($response);
$conn->close();
?>
