<?php
require 'db_connection.php';
session_start();

require 'vendor/autoload.php'; // ใช้ Composer โหลด Library
use Endroid\QrCode\Builder\Builder;

/* check payment */
// ---------------- เรียกข้อมูลจากdatabasse ---------------- //

//check user role
//getuserID from logincredentials
$username = $_SESSION['username'];
$getuserid = "SELECT UserID FROM logincredentials WHERE email = '$username'";
$result = $conn->query($getuserid);
$row = $result->fetch_assoc();
$UserID = $row['UserID'];
$_SESSION['CustomerID'] = $UserID;

//check user role
$getrole = "SELECT UserRole FROM users WHERE UserID = '$UserID'";
$result = $conn->query($getrole);
$row = $result->fetch_assoc();
$UserRole = $row['UserRole'];

if ($UserRole == 'Customer') {
    $stmt = $conn->prepare("SELECT * FROM customerpolicy WHERE CustomerID = ? AND PolicyID = ? AND PaymentStatus = ?");
    if (!$stmt) {
        echo "Database error: " . $conn->error;
        exit;
    }
    $stmt->bind_param("sis", $CustomerID, $PolicyID, $PaymentStatus);
    $CustomerID = $_SESSION['CustomerID'] ?? null;
    $PolicyID = $_GET['id'] ?? null;

    // ---------------- ตรวจสอบ UserId ---------------- //

    if (!$CustomerID || !$PolicyID) {
        echo "<script>alert('Invalid customer or policy information.'); window.history.back();</script>";
        exit;
    }
    $stmt->execute();
    $result = $stmt->get_result();

    // ---------------- ตรวขสอบสภานะการชำระ ---------------- //

    // ตรวจสอบผลลัพธ์
    if ($result->num_rows > 0) {
        // มีข้อมูลในฐานข้อมูลที่ PaymentStatus = 'Paid'
        echo "<script>alert('You have already paid for this package.'); window.history.back();</script>";
        exit;
    } else {
        // ไม่มีข้อมูลที่ PaymentStatus = 'Paid'
        echo "";
    }

    $policyID = htmlspecialchars($_GET['id']);
    $userID = $_SESSION['CustomerID'] ?? null;

    // ---------------- ตรวจสอบสถานะการสมัครแพ็คเกจ ---------------- //
    $stmt = $conn->prepare("SELECT PaymentStatus FROM customerpolicy WHERE CustomerID = ? AND PolicyID = ?");
    $stmt->bind_param("si", $userID, $policyID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $paymentStatus = $row['PaymentStatus'];

        // ----------------สร้าง Qr code ---------------- //
        if ($paymentStatus === 'Pending') {
            // สร้าง URL สำหรับ QR Code
            $url = "http://localhost/NOS_Webapplication/CS-payment-confirm.php?id=" . $policyID . "&UserID=" . $userID;

            try {
                // สร้าง QR Code เป็น base64
                $result = Builder::create()
                    ->data($url)
                    ->build();

                // แปลง QR Code เป็น base64 string
                $qrCodeBase64 = base64_encode($result->getString());
            } catch (Exception $e) {
                die("Error generating QR Code: " . $e->getMessage());
            }
        } elseif ($paymentStatus === 'Paid') {
            echo "<script>alert('This package has already been paid for.'); window.history.back();</script>";
            exit;
        }
    } else {
        echo "<script>alert('You have not applied for this package.'); window.history.back();</script>";
        exit;
    }
} else {
    $stmt = $conn->prepare("SELECT * FROM employeepolicy WHERE EmployeeID = ? AND PolicyID = ? AND PaymentStatus = ?");
    if (!$stmt) {
        echo "Database error: " . $conn->error;
        exit;
    }
    $stmt->bind_param("sis", $UserID, $PolicyID, $PaymentStatus);
    $CustomerID = $_SESSION['CustomerID'] ?? null;
    $PolicyID = $_GET['id'] ?? null;

    // ---------------- ตรวจสอบ UserId ---------------- //

    if (!$CustomerID || !$PolicyID) {
        echo "<script>alert('Invalid customer or policy information.'); window.history.back();</script>";
        exit;
    }
    $stmt->execute();
    $result = $stmt->get_result();

    // ---------------- ตรวขสอบสภานะการชำระ ---------------- //

    // ตรวจสอบผลลัพธ์
    if ($result->num_rows > 0) {
        // มีข้อมูลในฐานข้อมูลที่ PaymentStatus = 'Paid'
        echo "<script>alert('You have already paid for this package.'); window.history.back();</script>";
        exit;
    } else {
        // ไม่มีข้อมูลที่ PaymentStatus = 'Paid'
        echo "";
    }

    $policyID = htmlspecialchars($_GET['id']);
    $userID = $_SESSION['CustomerID'] ?? null;

    // ---------------- ตรวจสอบสถานะการสมัครแพ็คเกจ ---------------- //
    $stmt = $conn->prepare("SELECT PaymentStatus FROM employeepolicy WHERE EmployeeID = ? AND PolicyID = ?");
    $stmt->bind_param("si", $userID, $policyID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $paymentStatus = $row['PaymentStatus'];

        // ----------------สร้าง Qr code ---------------- //
        if ($paymentStatus === 'Pending') {
            // สร้าง URL สำหรับ QR Code
            $url = "http://localhost/NOS_Webapplication/CS-payment-confirm.php?id=" . $policyID . "&UserID=" . $userID;

            try {
                // สร้าง QR Code เป็น base64
                $result = Builder::create()
                    ->data($url)
                    ->build();

                // แปลง QR Code เป็น base64 string
                $qrCodeBase64 = base64_encode($result->getString());
            } catch (Exception $e) {
                die("Error generating QR Code: " . $e->getMessage());
            }
        } elseif ($paymentStatus === 'Paid') {
            echo "<script>alert('This package has already been paid for.'); window.history.back();</script>";
            exit;
        }
    } else {
        echo "<script>alert('You have not applied for this package.'); window.history.back();</script>";
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Payment</title>
    <link rel="stylesheet" href="css/payment.css">
</head>

<body>
    <h1>Scan QR Code to Proceed</h1>
    <img src="data:image/png;base64,<?php echo $qrCodeBase64; ?>" class="QRcode" alt="Qr Code">
    <p>After scanning, you will be redirected to the payment confirmation page.</p>
</body>

</html>