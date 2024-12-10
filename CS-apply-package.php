<?php
// ---------------- เชคสิทธิ์ในการสมัคร package ----------------//
    if (!isset($_SESSION['UserID'])) {
        echo "You need to log in to apply.";
        exit;
    }

    $userID = $_SESSION['UserID'];
    $policyID = $_GET['id'];

    // ---------------- ตรวจสอบบทบาทผู้ใช้ ---------------- //
    $sql = "SELECT UserRole FROM users WHERE UserID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($user['UserRole'] !== 'Customer') {
            echo "You are not authorized to apply for this package.";
            exit;
        }
    } else {
        echo "User not found.";
        exit;
    }

    // ---------------- ตรวจสอบว่าผู้ใช้งานสมัครแพ็คเกจนี้ไปแล้วหรือไม่ ----------------//
    $sql = "SELECT * FROM customerpolicy WHERE UserID = ? AND PolicyID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $userID, $policyID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "You have already applied for this package.";
        exit;
    }

    // ---------------- เพิ่มข้อมูลการสมัคร ----------------//

    $sql = "INSERT INTO customerpolicy (UserID, PolicyID, PaymentStatus, EnrollmentDate) 
        VALUES (?, ?, 'Pending', NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $userID, $policyID);

    if ($stmt->execute()) {
        echo "Your application has been submitted. Please proceed to payment.";
    } else {
        echo "Error: Unable to submit your application.";
    }

    //---------------- ระบบการยืนยันการชำระเงิน ----------------ฝฝ

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['PolicyID'])) {
        $policyID = $_POST['PolicyID'];
        $userID = $_SESSION['UserID'];
    
        // ---------------- อัปเดตสถานะการชำระเงิน ----------------ฝฝ
        $sql = "UPDATE customerpolicy SET PaymentStatus = 'Paid' WHERE UserID = ? AND PolicyID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $userID, $policyID);
    
        if ($stmt->execute()) {
            echo "Payment confirmed. Your enrollment is now complete.";
        } else {
            echo "Error: Unable to update payment status.";
        }
    }
?>
