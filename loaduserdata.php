<?php
header('Content-Type: application/json');
require 'db_connection.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'error' => 'User not logged in']);
    exit();
}

// Check if the request is POST and the email is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email']) && !empty($_POST['email'])) {
    $email = $_POST['email'];
    $username = $email;

    // Fetch userID using email
    $query = $conn->prepare("SELECT userID FROM logincredentials WHERE email = ?");
    $query->bind_param("s", $username);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $userID = $user['userID'];
    } else {
        echo json_encode(['success' => false, 'error' => 'Unable to retrieve userID']);
        exit();
    }

    try {
        // Query to fetch user data
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
            echo json_encode(['success' => false, 'error' => 'User data not found', 'userID' => $username]);
        }
    
        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    // Handle invalid or missing POST data
    echo json_encode(['success' => false, 'error' => 'Invalid request or missing email']);
    exit();
}
?>
