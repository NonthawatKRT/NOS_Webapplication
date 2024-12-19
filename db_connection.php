<?php
$servername = "localhost";
$username = "yourusername(Default: root)";
$password = "yourpassword";
$dbname = "nos_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
