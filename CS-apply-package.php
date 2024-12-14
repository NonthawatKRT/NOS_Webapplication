<?php

require 'db_connection.php';
session_start();

// ---------------- เชคสิทธิ์ในการสมัคร package ----------------//  

// Sanitize and validate `policyID` from `$_GET`
$policyID = $_GET['id'] ?? '';
if (!is_numeric($policyID)) {
    echo "<script>alert('Invalid Policy ID.'); window.history.back();</script>";
    exit;
}

$Email = $_SESSION['username'] ?? null;
if (!$Email) {
    echo "<script>alert('Please log in first.'); window.location.href = 'login.php';</script>";
    exit;
}

// Prepare SQL statement to fetch CustomerID
$stmt = $conn->prepare("SELECT CustomerID FROM customer WHERE email = ?");
$stmt->bind_param("s", $Email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $userID = $row['CustomerID']; // Assign the retrieved CustomerID
    $_SESSION['CustomerID'] = $userID; // Update session
} else {
    echo "<script>alert('Please log in.'); window.location.href = 'login.php';</script>";
    exit;
}

// ---------------- ตรวจสอบบทบาทผู้ใช้ ---------------- //
$stmt = $conn->prepare("SELECT UserRole FROM users WHERE UserID = ?");
if (!$stmt) {
    echo "<script>alert('Database error while checking user role.');</script>";
    exit;
}   
$stmt->bind_param("s", $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if ($user['UserRole'] !== 'Customer') {
        echo "<script>alert('You are not authorized to apply for this package.'); window.history.back();</script>";
        exit;
    }
} else {
    echo "<script>alert('User not found.'); window.history.back();</script>";
    exit;
}

// ---------------- ตรวจสอบว่าผู้ใช้งานสมัครแพ็คเกจนี้ไปแล้วหรือไม่ ----------------//
$stmt = $conn->prepare("SELECT * FROM customerpolicy WHERE CustomerID = ? AND PolicyID = ?");
if (!$stmt) {
    echo "<script>alert('Database error while checking existing applications.');</script>";
    exit;
}
$stmt->bind_param("si", $userID, $policyID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<script>alert('You have already applied for this package.'); window.history.back();</script>";
    exit;
}

// ---------------- เพิ่มข้อมูลการสมัคร ----------------//
$sql = "INSERT INTO customerpolicy (CustomerID, PolicyID, PaymentStatus, EnrollmentDate) 
    VALUES (?, ?, 'Pending', NOW())";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo "<script>alert('Database error while submitting application.');</script>";
    exit;
}
$stmt->bind_param("si", $userID, $policyID);

if ($stmt->execute()) {
    echo "<script>alert('Your application has been submitted. Please proceed to payment.'); window.history.back();</script>";
} else {
    echo "<script>alert('Error: Unable to submit your application.'); window.history.back();</script>";
}
?>
