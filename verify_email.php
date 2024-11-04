<?php 
// Connect to the database
require 'db_connection.php';

// Enable error display for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function renderPage($title, $message) {
    echo "
    <html>
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f9;
                color: #333;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }
            .container {
                background-color: white;
                border-radius: 8px;
                padding: 30px;
                max-width: 500px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                text-align: center;
            }
            h1 {
                color: #ff6b6b;
                font-size: 24px;
                margin-bottom: 20px;
            }
            p {
                font-size: 16px;
                line-height: 1.5;
                margin-bottom: 20px;
            }
            a {
                display: inline-block;
                padding: 10px 20px;
                background-color: #007BFF;
                color: white;
                text-decoration: none;
                border-radius: 5px;
                margin-top: 10px;
                transition: background-color 0.3s;
            }
            a:hover {
                background-color: #0056b3;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <h1>$title</h1>
            <p>$message</p>
            <a href='index.php'>Return to Homepage</a>
        </div>
    </body>
    </html>
    ";
}

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Prepare SQL to find the user with the provided token
    $sql = "SELECT userID FROM logincredentials WHERE verification_token = ? AND status = 'waiting for verify'";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        renderPage("Error", "There was an issue processing your request. Please try again later.");
        exit();
    }

    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    // Check if a user with the token exists
    if ($stmt->num_rows > 0) {
        // User found, update their status to 'Active'
        $sql = "UPDATE logincredentials SET status = 'Active' WHERE verification_token = ?";
        $update_stmt = $conn->prepare($sql);
        $update_stmt->bind_param("s", $token);

        if ($update_stmt->execute()) {
            // Update user role in `users` table
            $sql = "UPDATE users SET userRole = 'Customer' WHERE userID = (SELECT userID FROM logincredentials WHERE verification_token = ?)";
            $role_update_stmt = $conn->prepare($sql);
            $role_update_stmt->bind_param("s", $token);
            
            if ($role_update_stmt->execute()) {
                echo "<script>
                    alert('Email verified successfully! You can now log in.');
                    window.location.href = 'index.php';
                  </script>";
            } else {
                renderPage("Error", "There was an error updating your role. Please contact support.");
            }

            $role_update_stmt->close();
        } else {
            renderPage("Error", "There was an error updating your status. Please contact support.");
        }

        $update_stmt->close();
    } else {
        // Invalid or expired token
        renderPage("Invalid or Expired Token", "It looks like your verification link is invalid or has expired. Please check your email for a new verification link or contact support if you're having trouble.");
    }

    $stmt->close();
} else {
    // No token provided
    renderPage("No Token Provided", "It looks like you tried to access this page without a valid verification token.");
}

$conn->close();
?>
