<?php
header('Content-Type: application/json');
require 'db_connection.php';

// Retrieve POST parameters
$nationID = $_POST['nationid'] ?? null;
$email = $_POST['email'] ?? null;

// Validate required fields
if (!$nationID && !$email) {
    echo json_encode(['success' => false, 'error' => 'Either National ID or Email is required.']);
    exit();
}

// Prepare response structure
$response = ['success' => true];

// Check for duplicate National ID
if ($nationID) {
    $stmt1 = $conn->prepare("SELECT COUNT(*) as count FROM customer WHERE nationID = ?");
    $stmt1->bind_param("s", $nationID);
    $stmt1->execute();
    $result1 = $stmt1->get_result()->fetch_assoc();

    if ($result1['count'] > 0) {
        $response['success'] = false;
        $response['error'] = 'National ID already exists.';
    }
    $stmt1->close();
}

// Check for duplicate Email
if ($email) {
    $stmt2 = $conn->prepare("SELECT COUNT(*) as count FROM customer WHERE email = ?");
    $stmt2->bind_param("s", $email);
    $stmt2->execute();
    $result2 = $stmt2->get_result()->fetch_assoc();

    if ($result2['count'] > 1) {
        $response['success'] = false;
        $response['error'] = 'Email already exists.';
    }
    $stmt2->close();
}

// Close the connection
$conn->close();

// Return the response
echo json_encode($response);
?>
