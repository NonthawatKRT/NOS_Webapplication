<?php
header('Content-Type: application/json');
require 'db_connection.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'error' => 'User not logged in']);
    exit();
}

// If userID is not set, fetch it using the username
if (!isset($_SESSION['userID'])) {
    $username = $_SESSION['username'];

    $query = $conn->prepare("SELECT userID FROM logincredentials WHERE email = ?");
    $query->bind_param("s", $username);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $_SESSION['userID'] = $user['userID'];
    } else {
        echo json_encode(['success' => false, 'error' => 'Unable to retrieve userID']);
        exit();
    }
}

// Use userID for further operations
$userID = $_SESSION['userID'];

try {
    // Query to fetch data from both tables
    $stmt = $conn->prepare("
        SELECT 
            c.customerID, c.nationID, c.dob AS dateOfBirth, c.postalcode AS postcode, c.phonenumber AS phoneNumber, 
            lc.email, c.firstname, c.lastname, c.gender, c.address, c.ethnicity, c.nationality, 
            c.district, c.province, c.occupation, c.salary, c.workplace, c.healthhistory, 
            c.medicalhistory, c.weight, c.height 
        FROM customer c
        INNER JOIN logincredentials lc ON c.customerID = lc.userID
        WHERE c.customerID = ?
    ");
    $stmt->bind_param("s", $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $userData = $result->fetch_assoc();
        echo json_encode(['success' => true, 'data' => $userData]);
    } else {
        echo json_encode(['success' => false, 'error' => 'User data not found']);
    }

    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
