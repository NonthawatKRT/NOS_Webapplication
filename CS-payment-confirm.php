<?php
require 'db_connection.php';
session_start();

if (isset($_GET['id'], $_GET['UserID']) && is_numeric($_GET['id'])) {
    $policyID = htmlspecialchars($_GET['id']);
    $userID = htmlspecialchars($_GET['UserID']);

    // อัปเดตสถานะการชำระเงิน
    $sql = "UPDATE customerpolicy SET PaymentStatus = 'Paid' WHERE CustomerID = ? AND PolicyID = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo "Database error: " . $conn->error;
        exit;
    }

    $stmt->bind_param("ii", $userID, $policyID);

    if ($stmt->execute()) {
        echo "
        <script>
            alert('Payment confirmed!');
                window.location.href = 'index.php';
        </script>
        ";
        exit;

    } else {
        echo "Error: Unable to update payment status."; 
    }
} else {
    echo "Invalid parameters.";
}
?>

