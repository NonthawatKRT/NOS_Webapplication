<?php
// form_sales.php
require 'db_connection.php';

// รับ token จาก URL
$token = $_GET['token'] ?? null;

if (!$token) {
    echo "Invalid token.";
    exit();
}

// ค้นหาข้อมูลผู้สมัครจาก token
$stmt = $conn->prepare("SELECT userID, firstname, lastname FROM logincredentials WHERE verification_token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows == 0) {
    echo "Invalid token.";
    exit();
}

$stmt->bind_result($userID, $firstName, $lastName);
$stmt->fetch();
$stmt->close();

// ฟอร์มให้ผู้สมัครกรอกข้อมูล
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // รับข้อมูลจากฟอร์ม
    $product = $_POST['product'] ?? null;
    $quantity = $_POST['quantity'] ?? 0;
    $price = $_POST['price'] ?? 0;

    if ($product && $quantity > 0 && $price > 0) {
        // บันทึกข้อมูลลงในตาราง sales
        $stmt2 = $conn->prepare("INSERT INTO sales (userID, product, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt2->bind_param("ssdd", $userID, $product, $quantity, $price);
        $stmt2->execute();
        echo "Your information has been saved.";
    } else {
        echo "Please fill in all the fields correctly.";
    }
}
?>

<form method="POST">
    <label for="product">Product:</label>
    <input type="text" name="product" id="product" required><br>
    <label for="quantity">Quantity:</label>
    <input type="number" name="quantity" id="quantity" required><br>
    <label for="price">Price:</label>
    <input type="number" name="price" id="price" required><br>
    <button type="submit">Submit</button>
</form>
