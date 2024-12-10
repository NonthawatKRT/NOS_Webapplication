<?php
 require 'db_connection.php';
require 'vendor/autoload.php'; // ใช้ Composer โหลด Library

use Endroid\QrCode\QrCode; // ใช้คลาสที่ถูกต้อง
use Endroid\QrCode\Writer\PngWriter; // ใช้ Writer สำหรับสร้างไฟล์ PNG

if (isset($_GET['PolicyID']) && is_numeric($_GET['PolicyID'])) {
    $policyId = htmlspecialchars($_GET['PolicyID']);
    $url = "http://localhost/NOS_Webapplication/CS-package-details.php?id=" . $policyId;

    // สร้าง QR Code
    $qrCode = QrCode::create($url)
        ->setSize(300) // ขนาด QR Code
        ->setMargin(10); // ระยะขอบ

    // ใช้ Writer สำหรับสร้างไฟล์ PNG
    $writer = new PngWriter();

    // แสดงผล QR Code เป็นรูปภาพ
    header('Content-Type: image/png');
    echo $writer->write($qrCode)->getString();
    exit;
} else {
    // แสดงข้อผิดพลาดหาก policy_id ไม่ถูกต้อง
    echo "Invalid policy ID.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Payment</title>
</head>
<body>
    <h1>Scan QR Code to Proceed to Payment</h1>
    <img src="generate_qr.php?PolicyID=<?php echo isset($_GET['PolicyID']) ? htmlspecialchars($_GET['policy_id']) : 1; ?>" alt="QR Code">
    <p>After scanning, you will be redirected to the payment confirmation page.</p>
</body>
</html>
