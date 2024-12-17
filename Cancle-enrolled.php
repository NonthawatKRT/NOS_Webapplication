<?php
// Start the session
session_start();

// Include database connection
require 'db_connection.php'; // Replace with your actual database connection file

try {
    echo "Connected successfully<br>";

    // Check if 'id' is passed in the URL and the request method is POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id']) && isset($_SESSION['username'])) {
        $policyID = $_GET['id'];
        $username = $_SESSION['username'];

        //check user role
        //getuserID from logincredentials
        $getuserid = "SELECT UserID FROM logincredentials WHERE email = '$username'";
        $result = $conn->query($getuserid);
        $row = $result->fetch_assoc();
        $UserID = $row['UserID'];

        //check user role
        $getrole = "SELECT UserRole FROM users WHERE UserID = '$UserID'";
        $result = $conn->query($getrole);
        $row = $result->fetch_assoc();
        $UserRole = $row['UserRole'];

        if ($UserRole == 'Customer') {
            // Step 1: Get the UserID based on the username
            $getUserID = "SELECT customerID FROM customer WHERE email = ?";
            $stmt = $conn->prepare($getUserID);
            if (!$stmt) {
                throw new Exception("Error preparing statement (UserID query): " . $conn->error);
            }

            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 0) {
                throw new Exception("No user found for the provided username.");
            }

            $row = $result->fetch_assoc();
            $customerID = $row['customerID'];

            // Step 2: Validate and sanitize PolicyID
            $policyID = filter_var($policyID, FILTER_VALIDATE_INT);
            if ($policyID === false) {
                throw new Exception("Invalid Policy ID.");
            }

            // Step 3: Delete the entry in customerpolicy table
            $deleteSQL = "DELETE FROM customerpolicy WHERE PolicyID = ? AND CustomerID = ?";
            $stmt = $conn->prepare($deleteSQL);
            if (!$stmt) {
                throw new Exception("Error preparing DELETE statement: " . $conn->error);
            }

            // Bind parameters
            $stmt->bind_param("is", $policyID, $customerID); // "i" for int, "s" for string

            // Execute the DELETE query
            if (!$stmt->execute()) {
                throw new Exception("Error executing DELETE statement: " . $stmt->error);
            }

            // Success message and redirection
            echo "Package removed successfully!";
            header("Location: userprofile.php");
            exit();
        }
    else{
        // Step 1: Get the UserID based on the username
        $getUserID = "SELECT EmployeeID FROM employees WHERE email = ?";
        $stmt = $conn->prepare($getUserID);
        if (!$stmt) {
            throw new Exception("Error preparing statement (UserID query): " . $conn->error);
        }

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            throw new Exception("No user found for the provided username.");
        }

        $row = $result->fetch_assoc();
        $customerID = $row['EmployeeID'];

        // Step 2: Validate and sanitize PolicyID
        $policyID = filter_var($policyID, FILTER_VALIDATE_INT);
        if ($policyID === false) {
            throw new Exception("Invalid Policy ID.");
        }

        // Step 3: Delete the entry in customerpolicy table
        $deleteSQL = "DELETE FROM employeepolicy WHERE PolicyID = ? AND EmployeeID = ?";
        $stmt = $conn->prepare($deleteSQL);
        if (!$stmt) {
            throw new Exception("Error preparing DELETE statement: " . $conn->error);
        }

        // Bind parameters
        $stmt->bind_param("is", $policyID, $customerID); // "i" for int, "s" for string

        // Execute the DELETE query
        if (!$stmt->execute()) {
            throw new Exception("Error executing DELETE statement: " . $stmt->error);
        }

        // Success message and redirection
        echo "Package removed successfully!";
        header("Location: userprofile.php");
        exit();
    } 
}

} catch (Exception $e) {
    // Catch any errors and display them
    echo "An error occurred: " . $e->getMessage();
}

// Close connection
if (isset($stmt)) {
    $stmt->close();
}
$conn->close();
