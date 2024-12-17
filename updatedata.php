<?php
header('Content-Type: application/json');
require 'db_connection.php';
session_start();

if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'error' => 'User not logged in']);
    exit();
}

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

$userID = $_SESSION['userID'];

$rolecheck = $conn->prepare("SELECT userRole FROM users WHERE userID = ?");
$rolecheck->bind_param("s", $userID);
$rolecheck->execute();
$role = $rolecheck->get_result()->fetch_assoc();

if ($role['userRole'] == 'Customer') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data) {
        echo json_encode(['success' => false, 'error' => 'Invalid input']);
        exit();
    }

    function validatePassword($password)
    {
        $passwordPattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*\-^]).{8,}$/";
        return preg_match($passwordPattern, $password);
    }

    $error = [];
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $error[] = 'Invalid email format.';
    }
    if (strlen($data['nationID']) !== 13 || !ctype_digit($data['nationID'])) {
        $error[] = 'NationID must be exactly 13 digits.';
    }
    if (!empty($error)) {
        echo json_encode(['success' => false, 'error' => $error]);
        exit();
    }

    // Check if email already exists
    $emailCheckStmt = $conn->prepare("SELECT COUNT(*) as count FROM logincredentials WHERE email = ? AND userID != ?");
    $emailCheckStmt->bind_param("ss", $data['email'], $userID);
    $emailCheckStmt->execute();
    $emailCheckResult = $emailCheckStmt->get_result()->fetch_assoc();

    if ($emailCheckResult['count'] > 0) {
        echo json_encode(['success' => false, 'error' => 'Email is already in use by another account.']);
        exit();
    }

    // Check if nationID already exists
    $nationIDCheckStmt = $conn->prepare("SELECT COUNT(*) as count FROM employees WHERE nationID = ? AND employeeID != ?");
    $nationIDCheckStmt->bind_param("ss", $data['nationID'], $userID);
    $nationIDCheckStmt->execute();
    $nationIDCheckResult = $nationIDCheckStmt->get_result()->fetch_assoc();

    $nationIDCheckStmt2 = $conn->prepare("SELECT COUNT(*) as count FROM customer WHERE nationID = ? AND customerID != ?");
    $nationIDCheckStmt2->bind_param("ss", $data['nationID'], $userID);
    $nationIDCheckStmt2->execute();
    $nationIDCheckResult2 = $nationIDCheckStmt2->get_result()->fetch_assoc();

    if ($nationIDCheckResult['count'] > 0) {
        echo json_encode(['success' => false, 'error' => 'Nation ID is already in use by another account.']);
        exit();
    }

    // If no duplicates, proceed with the update
    try {
        $conn->begin_transaction();

        // Update customer table
        $stmt3 = $conn->prepare("
        UPDATE customer SET 
            firstname = ?, lastname = ?, gender = ?, address = ?, 
            postalcode = ?, phonenumber = ?, district = ?, province = ?, 
            ethnicity = ?, nationality = ?, occupation = ?, salary = ?, 
            workplace = ?, healthhistory = ?, medicalhistory = ?, 
            weight = ?, height = ?, nationID = ? WHERE customerID = ?
    ");
        $stmt3->bind_param(
            "sssssssssssssssssss",
            $data['firstname'],
            $data['lastname'],
            $data['gender'],
            $data['address'],
            $data['postcode'],
            $data['phoneNumber'],
            $data['district'],
            $data['province'],
            $data['ethnicity'],
            $data['nationality'],
            $data['occupation'],
            $data['salary'],
            $data['workplace'],
            $data['healthhistory'],
            $data['medicalhistory'],
            $data['weight'],
            $data['height'],
            $data['nationID'],
            $userID
        );
        $stmt3->execute();

        // Update logincredentials table
        if (!empty($data['password'])) {
            if (!validatePassword($data['password'])) {
                echo json_encode(['success' => false, 'error' => 'Invalid password format.']);
                exit();
            }

            $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);
            $stmt4 = $conn->prepare("UPDATE logincredentials SET email = ?, passwordhash = ? WHERE userID = ?");
            $stmt4->bind_param("sss", $data['email'], $passwordHash, $userID);
        } else {
            $stmt4 = $conn->prepare("UPDATE logincredentials SET email = ? WHERE userID = ?");
            $stmt4->bind_param("ss", $data['email'], $userID);
        }

        // Update the customer table's email
        $stmt5 = $conn->prepare("UPDATE customer SET email = ? WHERE customerID = ?");
        $stmt5->bind_param("ss", $data['email'], $userID);

        // Execute the statements with error handling
        if (!$stmt4->execute() || !$stmt5->execute()) {
            echo json_encode(['success' => false, 'error' => 'Database update failed.']);
            exit();
        }

        // Close the prepared statements
        $stmt4->close();
        $stmt5->close();

        // Commit the transaction
        $conn->commit();

        // Send a single JSON response
        echo json_encode(['success' => true, 'message' => 'Profile and data updated successfully']);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {

    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data) {
        echo json_encode(['success' => false, 'error' => 'Invalid input']);
        exit();
    }

    function validatePassword($password)
    {
        $passwordPattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*\-^]).{8,}$/";
        return preg_match($passwordPattern, $password);
    }

    $error = [];
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $error[] = 'Invalid email format.';
    }
    if (strlen($data['nationID']) !== 13 || !ctype_digit($data['nationID'])) {
        $error[] = 'NationID must be exactly 13 digits.';
    }
    if (!empty($error)) {
        echo json_encode(['success' => false, 'error' => $error]);
        exit();
    }

    // Check if email already exists
    $emailCheckStmt = $conn->prepare("SELECT COUNT(*) as count FROM logincredentials WHERE email = ? AND userID != ?");
    $emailCheckStmt->bind_param("ss", $data['email'], $userID);
    $emailCheckStmt->execute();
    $emailCheckResult = $emailCheckStmt->get_result()->fetch_assoc();

    if ($emailCheckResult['count'] > 0) {
        echo json_encode(['success' => false, 'error' => 'Email is already in use by another account.']);
        exit();
    }

    // Check if nationID already exists
    $nationIDCheckStmt = $conn->prepare("SELECT COUNT(*) as count FROM employees WHERE nationID = ? AND employeeID != ?");
    $nationIDCheckStmt->bind_param("ss", $data['nationID'], $userID);
    $nationIDCheckStmt->execute();
    $nationIDCheckResult = $nationIDCheckStmt->get_result()->fetch_assoc();

    $nationIDCheckStmt2 = $conn->prepare("SELECT COUNT(*) as count FROM customer WHERE nationID = ? AND customerID != ?");
    $nationIDCheckStmt2->bind_param("ss", $data['nationID'], $userID);
    $nationIDCheckStmt2->execute();
    $nationIDCheckResult2 = $nationIDCheckStmt2->get_result()->fetch_assoc();


    if ($nationIDCheckResult['count'] > 0) {
        echo json_encode(['success' => false, 'error' => 'Nation ID is already in use by another account.']);
        exit();
    }

    if ($nationIDCheckResult2['count'] > 0) {
        echo json_encode(['success' => false, 'error' => 'Nation ID is already in use by another account.']);
        exit();
    }

    // If no duplicates, proceed with the update
    try {
        $conn->begin_transaction();

        // Update customer table
        $stmt3 = $conn->prepare("
        UPDATE employees SET 
            firstname = ?, lastname = ?, gender = ?, address = ?, 
            postalcode = ?, phonenumber = ?, district = ?, province = ?, 
            ethnicity = ?, nationality = ?, occupation = ?, salary = ?, 
            workplace = ?, healthhistory = ?, medicalhistory = ?, 
            weight = ?, height = ?, nationID = ? WHERE employeeID = ?
    ");
        $stmt3->bind_param(
            "sssssssssssssssssss",
            $data['firstname'],
            $data['lastname'],
            $data['gender'],
            $data['address'],
            $data['postcode'],
            $data['phoneNumber'],
            $data['district'],
            $data['province'],
            $data['ethnicity'],
            $data['nationality'],
            $data['occupation'],
            $data['salary'],
            $data['workplace'],
            $data['healthhistory'],
            $data['medicalhistory'],
            $data['weight'],
            $data['height'],
            $data['nationID'],
            $userID
        );
        $stmt3->execute();

        // Update logincredentials table
        if (!empty($data['password'])) {
            if (!validatePassword($data['password'])) {
                echo json_encode(['success' => false, 'error' => 'Invalid password format.']);
                exit();
            }

            $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);
            $stmt4 = $conn->prepare("UPDATE logincredentials SET email = ?, passwordhash = ? WHERE userID = ?");
            $stmt4->bind_param("sss", $data['email'], $passwordHash, $userID);
        } else {
            $stmt4 = $conn->prepare("UPDATE logincredentials SET email = ? WHERE userID = ?");
            $stmt4->bind_param("ss", $data['email'], $userID);
        }

        // Update the customer table's email
        $stmt5 = $conn->prepare("UPDATE employees SET email = ? WHERE employeeID = ?");
        $stmt5->bind_param("ss", $data['email'], $userID);

        // Execute the statements with error handling
        if (!$stmt4->execute() || !$stmt5->execute()) {
            echo json_encode(['success' => false, 'error' => 'Database update failed.']);
            exit();
        }

        // Close the prepared statements
        $stmt4->close();
        $stmt5->close();

        // Commit the transaction
        $conn->commit();

        // Send a single JSON response
        echo json_encode(['success' => true, 'message' => 'Profile and data updated successfully']);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
