<?php
$servername = "localhost";
$username = "root";
$password = "Nonthawat4826";
$dbname = "nos_db(1)";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
