<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login2.css"> <!-- Link to your CSS file -->
</head>
<body>

<?php
require 'db_connection.php';
session_start();

$error = '';

if (isset($_POST['submit'])) {
    $Email = $_POST['username'];
    $Password = $_POST['password'];

    // Check for admin login
    if ($Email === 'admin' && $Password === 'adminoat') {
        $_SESSION['username'] = $Email;
        $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'index.php';
        header("Location: $redirect");
        exit();
    } else {
        // Fetch the user data from the database
        $stmt = $conn->prepare("SELECT PasswordHash, status FROM logincredentials WHERE email = ?");
        $stmt->bind_param("s", $Email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $storedHash = $row['PasswordHash'];
            $status = $row['status']; // Get the user's verification status

            // Verify the entered password against the stored hash
            if (password_verify($Password, $storedHash)) {
                // Check if the user's email is verified
                if ($status === 'Active') {
                    $_SESSION['username'] = $Email;
                    $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'index.php';
                    header("Location: $redirect");
                    exit();
                } else {
                    $error = "Your email is not verified. Please check your inbox for the verification email.";
                }
            } else {
                $error = "Wrong username/password combination";
            }
        } else {
            $error = "Wrong username/password combination";
        }

        $stmt->close();
    }
}
$conn->close();
?>

    <!-- Navigation Bar -->
    <nav>
        <div class="nav-container">
            <div class="left">
                <a href="index.php" class="logo" style="padding:10px;">NOS Insurance</a>
                <ul class="nav-links">
                    <li><a href="index.php">HOME</a></li>
                    <li><a href="">CONTENT</a></li>
                    <li><a href="">PACKAGES</a></li>
                    <P style="margin-left: 20px; margin-top: 0px; margin-bottom: 0px;"> | </P>
                    <li><a href="">ABOUT US</a></li>
                </ul>
            </div>
            <div class="right">
                <a href="" class="contact"><img src="https://media-public.canva.com/MADpju8igYE/1/thumbnail.png" alt="" class="contactlogo"></a>
                <a href="" class="contact"><img src="https://media-public.canva.com/pz2bs/MAETCKpz2bs/1/t.png" alt="" class="searchlogo"></a>

                    <li class="loginbtcontainer"><a href="login.php" class="loginbt">Login/Sign in</a></li>

            </div>
        </div>
    </nav>
    
        <div class="login-section">
            <h2>Login</h2>
            <!-- Display the error message if it exists -->
            <?php if ($error == "Wrong username/password combination"): ?>
                <div class="alert">
                    <p>Wrong username/password combination</p>
                </div>
            <?php endif; ?>
            <?php if ($error == "Your email is not verified. Please check your inbox for the verification email."): ?>
                <div class="alert">
                    <p>Your email is not verified. Please check your inbox for the verification email.</p>
                </div>
            <?php endif; ?>
    
            <form action="login.php" method="post">
                <label for="username">เลขบัตรประชาชน</label>
                <input type="text" id="username" name="username" placeholder="ระบุเลขรหัสประชาชน 13 หลัก" required>
    
                <label for="password">รหัสผ่าน</label>
                <input type="password" id="password" name="password" placeholder="กรอกรหัสผ่าน" required>
    
                <!-- Flexbox for Forgot Password and Register -->
                <div class="link-container">
                    <div class="register">
                        <a href="register.html">สมัครสมาชิก</a>
                    </div>
                    <div class="forgot-password">
                        <a href="forgot_password.php">ลืมรหัสผ่าน?</a>
                    </div>
                </div>
    
                <input type="submit" name="submit" value="Submit">
            </form>
        </div>
    
        <!-- Footer -->
        <div class="footer">
            <p>&copy; 2024 Life Insurance Company. All rights reserved.</p>
        </div>

</body>
</html>
