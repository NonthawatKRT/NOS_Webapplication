<!-- ----------------------------------------------------------- Verify OTP Page ------------------------------------------------
files use:
    require 'db_connection.php';
    require 'verifyotp.css';
    require 'Navbar.css';
    require 'Footer.css';
    require 'scrollfade.js';
    require 'smoothscroll.js';
---------------------------------------------------------------------------------------------------------------------------- -->


<?php
require 'db_connection.php';

$error = '';

if (isset($_POST['verify_otp'])) {
    $email = $_POST['email'];
    $otp = $_POST['otp'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Define the password validation function
    function validatePassword($password)
    {
        $passwordRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*\-^]).{8,}$/';
        if (!preg_match($passwordRegex, $password)) {
            return "Password must include at least 1 uppercase letter, 1 lowercase letter, 1 number, and 1 special character (!@#$%^&*-^), and must be at least 8 characters long.";
        }
        return null; // No errors
    }

    // Check password requirements
    $passwordValidationError = validatePassword($new_password);
    if ($passwordValidationError) {
        $error = $passwordValidationError;
    } else {
        // Check if the OTP is valid
        $stmt = $conn->prepare("SELECT OTP, OTP_expires_at FROM logincredentials WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stored_otp = $row['OTP'];
            $expires_at = $row['OTP_expires_at'];

            if ($otp === $stored_otp && strtotime($expires_at) > time()) {
                // OTP is valid and not expired
                if ($new_password === $confirm_password) {
                    // Hash the new password and update it in the database
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                    $stmt2 = $conn->prepare("UPDATE logincredentials SET PasswordHash = ?, OTP = NULL, OTP_expires_at = NULL WHERE email = ?");
                    $stmt2->bind_param("ss", $hashed_password, $email);
                    $stmt2->execute();

                    $error = "Your password has been successfully reset.";

                    
                    // Display the message and delay redirection
                    echo "
                        <!DOCTYPE html>
                        <html lang='en'>
                        <head>
                            <meta charset='UTF-8'>
                            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                            <title>Password Reset Successful</title>
                            <link rel='stylesheet' href='css/verifyotp.css'> <!-- Include the updated CSS -->
                        </head>
                        <body>
                            <div class='contentcontainer fade-up'>
                                <div class='success-container'>
                                    <img src='images/Confirmmark.png' alt='Success Checkmark'>
                                    <p class='alert alert-success'>Your password has been successfully reset.</p>
                                    <p>Redirecting to the login page in 10 seconds...</p>
                                    <a href='login.php' class='btn'>Go to Login</a>
                                </div>
                            </div>
                            <script src='js/scrollfade.js'></script>
                            <script>
                                setTimeout(() => {
                                    window.location.href = 'login.php';
                                }, 10000); // Redirect after 10 seconds
                            </script>
                        </body>
                        </html>
                        ";
                    exit();

                } else {
                    $error = "Passwords do not match.";
                }
            } else {
                $error = "Invalid or expired OTP.";
            }
        } else {
            $error = "Invalid email or OTP.";
        }

        $stmt->close();
    }
}
$conn->close();
?>

<!-- ------------------------------------------------------- HTML ------------------------------------------------------- -->


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <link rel="stylesheet" href="css/verifyotp.css">
    <link rel="stylesheet" href="css/Navbar.css">
    <link rel="stylesheet" href="css/Footer.css">
</head>

<body>
    <!-- ---------------------------------------------------------- NavBar Section ---------------------------------------------------------- -->
    <nav>
        <div class="nav-container">
            <div class="left">
                <a href="index.php" class="logo"><img class="NOSlogo" src="images/NOSlogo.png" alt=""></a>
                <ul class="nav-links">
                    <li><a href="index.php" id="current_page">HOME</a></li>
                    <li><a href="content.php">CONTENT</a></li>
                    <li><a href="CS-package.php">PACKAGES</a></li>
                    <P style=" margin-top: 0px; margin-bottom: 0px; margin-right: 20px;"> | </P>
                    <li><a href="">ABOUT US</a></li>
                </ul>
            </div>
            <div class="right">
                <!-- <a href="" class="contact"><img src="https://media-public.canva.com/MADpju8igYE/1/thumbnail.png" alt="" class="contactlogo"></a> -->
                <!-- <a href="" class="contact"><img src="images/searchicon.png" alt="" class="searchlogo"></a> -->
                <?php if (isset($_SESSION['username'])): ?>
                    <?php
                    // Check if a profile picture exists for the logged-in user
                    $username = $_SESSION['username'];
                    $profilePicturePath = "userprofiles/" . $username . ".png";

                    // If no profile picture, use the default image
                    if (!file_exists($profilePicturePath)) {
                        $profilePicturePath = "userprofiles/Default.png";
                    }
                    ?>
                    <li class="profilepiccontainer">
                        <a href="userprofile.php">
                            <div class="profileframe">
                                <img src="<?php echo $profilePicturePath; ?>" alt="User Profile Picture" class="user-profile-pic">
                            </div> 
                        </a>
                    </li>
                <?php else: ?>
                    <li class="loginbtcontainer">
                        <a href="login.php" class="loginbt">Login</a>
                    </li>
                <?php endif; ?>
                <!-- <a href="" class="languagebt">EN/TH</a> -->
            </div>
        </div>
    </nav>

    <section class="verify-otp-section fade-up">
        <h1>Verify OTP</h1>

        <!-- Display an error or success message -->
        <?php if (!empty($error)): ?>
            <p class="alert <?php echo (strpos($error, 'successfully reset') !== false) ? 'alert-success' : 'alert-error'; ?>">
                <?php echo htmlspecialchars($error); ?>
            </p>
            <!-- <?php if (strpos($error, 'successfully reset') !== false): ?>
                <script>
                    setTimeout(() => {
                        window.location.href = "login.php";
                    }, 1000); // Redirect after 3 seconds
                </script>
            <?php endif; ?> -->
        <?php endif; ?>



        <form action="verifyotp.php" method="POST">
            <label for="email">Enter your email address:</label>
            <input type="email" id="email" name="email" required>

            <label for="otp">Enter the OTP:</label>
            <input type="text" id="otp" name="otp" required>

            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password" required>

            <label for="confirm_password">Confirm New Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <div class="passwordrequirement">
                <p><span style="font-weight:bold; font-size:18px;">&middot;</span> Password must be at least 8 characters long</p>
                <p><span style="font-weight:bold; font-size:18px;">&middot;</span> Special Character contain !,@,#,$,%,^,&,*,-,^ </p>
                <p><span style="font-weight:bold; font-size:18px;">&middot;</span> Password must include uppercase letter, lowercase letter, number and &nbsp; special character</p>

            </div>



            <button type="submit" name="verify_otp">Reset Password</button>
        </form>
    </section>

    <!-- ------------------------------------------------------ Footer Section ---------------------------------------------------------- -->

    <div class="footer">
        <hr>
        <div class="footercontainer">
            <div class="footerrow">
                <div class="logoandapp">
                    <div class="flogocontainer">
                        <img src="images/logo.png" alt="Logo" class="flogo">
                    </div>
                    <div class="fappcontainer">
                        <img src="images/xlogo-removebg-.png" alt="" class="applogo">
                        <img src="images/instagramlogo-removebg.png" alt="" class="applogo">
                        <img src="images/youtubelogo-removebg.png" alt="" class="applogo">
                        <img src="images/inlogo-removebg.png" alt="" class="applogo">
                    </div>
                </div>
                <div class="footercontentrow">
                    <p class="fcontenttittle">User cases</p>
                    <p>UI design</p>
                    <p>UX design</p>
                    <p>Wireframing</p>
                    <p>Diagramming</p>
                    <p>Brainstorming</p>
                    <p>Online whiteboard</p>
                    <p>Team collaboration</p>
                </div>
                <div class="footercontentrow">
                    <p class="fcontenttittle">Explore</p>
                    <p>Design</p>
                    <p>Prototyping</p>
                    <p>Development features</p>
                    <p>Design systems</p>
                    <p>Collaboration features</p>
                    <p>Design process</p>
                    <p>FigJam</p>
                </div>
                <div class="footercontentrow">
                    <p class="fcontenttittle">Resources</p>
                    <p>Blog</p>
                    <p>Best practices</p>
                    <p>Colors</p>
                    <p>Color wheel</p>
                    <p>Support</p>
                    <p>Developers</p>
                    <p>Resource library</p>
                </div>
                <div class="upiconcontainer">
                    <a href=""><img src="images/uparrow.png" alt="" class="upicon"></a>
                </div>
            </div>
            <div class="coppyright">
                <p>&copy; 2024 Life Insurance Company. All rights reserved.</p>
            </div>
        </div>
    </div>

    <script src="js/smoothscroll.js"></script>
    <script src="js/scrollfade.js"></script>


</body>

</html>