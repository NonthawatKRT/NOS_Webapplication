<!-- ------------------------------------------------------ Forget Password Page -------------------------------------------------
file use:
require 'db_connection.php';
require_once 'switfmailer/vendor/autoload.php'; // SwiftMailer autoload
require 'smoothscroll.js';
require 'scrollfade.js';
require 'Navbar.css';
require 'forgetpassword.css';
require 'Footer.css';
----------------------------------------------------------------------------------------------------------------------------- -->

<?php
require 'db_connection.php';
require_once 'switfmailer/vendor/autoload.php'; // SwiftMailer autoload

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$error = '';
$resetAvailable = false;

if (isset($_POST['submit'])) {
    $email = $_POST['email'];

    // Check if the email exists in the database
    $stmt = $conn->prepare("SELECT email FROM logincredentials WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email exists
        $resetAvailable = true;
        $otp = random_int(100000, 999999); // Generate a 6-digit OTP
        $expires_at = date("Y-m-d H:i:s", strtotime('+10 minutes')); // OTP valid for 10 minutes

        // Store the OTP and its expiration in the database
        $stmt2 = $conn->prepare("UPDATE logincredentials SET OTP = ?, OTP_expires_at = ? WHERE email = ?");
        $stmt2->bind_param("sss", $otp, $expires_at, $email);
        $stmt2->execute();

        //  ---------------------------------------- Send the OTP to the user's email -------------------------------------------

        $transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
            ->setUsername('NonthawatForStudy@gmail.com')
            ->setPassword('ifre wgkn uknu ecox')
            ->setStreamOptions([
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ],
            ]);

        $mailer = new Swift_Mailer($transport);

        $resetpassword_link = "http://localhost/NOS_Webapplication/verifyotp.php";
        $subject = "Your Password Reset OTP";
        $bodycontent = "
                <html>
                    <head>
                        <style>
                            .email-container { font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 8px; text-align: center; }
                            .header { text-align: center; background-color: #7f878f; color: white; padding: 10px; border-radius: 8px 8px 0 0; }
                            .header img { max-width: 150px; margin-bottom: 4px; margin-top: 20px; }
                            .content { padding: 10px 20px 0px 20px; }
                            .content p { font-size: 16px; line-height: 1.6; color: #333; }
                            .btn { display: inline-block; padding: 10px 30px; font-size: 16px; background-color: #39a752; color: white; text-decoration: none; border-radius: 5px; margin-top: 5px; margin-bottom: 5px; }
                            .footer { text-align: center; padding: 10px; font-size: 12px; color: #999; display: flex; justify-content: space-between; margin-top: 0px; }
                            .footer div { margin: 5px 0; display: flex; }
                            .otp { font-size: 20px; font-weight: bold; color: #333; backtronud-color: #f9f9f9; padding: 10px; border-radius: 5px; margin-top: 10px; margin-bottom: 10px; }
                        </style>
                    </head>
                    <body>
                        <div class='email-container'>
                            <div class='header'>
                                <img src='https://drive.google.com/uc?export=view&id=171zpal8y6noIqEJ2uK6LPm7tmzY-2KxC' alt='Your Logo'>
                                <h1>RESET PASSWORD OTP</h1>
                            </div>
                            <div class='content'>
                                <p>This is your reset password otp please use it in 10 minute! Click reset password button below to reset your password</p>
                                <p class='otp'>OTP: $otp</p>
                                <p><a href='$resetpassword_link' class='btn'>Reset Password</a></p>
                                <p>If the button above doesn't work, copy and paste the following link into your browser:</p>
                                <p><a href='$resetpassword_link'>$resetpassword_link</a></p>
                            </div>
                            <div class='footer'>
                                <div><p style='margin-right: 5px;'>Best regards,</p><p>Nonthawat For Study Team</p></div>
                                <div><p>&copy; 2024 Nonthawat For Study. All rights reserved.</p></div>
                            </div>
                        </div>
                    </body>
                </html>";

        $message = (new Swift_Message($subject))
            ->setFrom(['NonthawatForStudy@gmail.com' => 'Nonthawat For Study'])
            ->setTo([$email => 'Valued User'])
            ->setBody($bodycontent, 'text/html');

        if ($mailer->send($message)) {
            $error = "An OTP has been sent , Check your email!";
        } else {
            $error = "Failed to send the email. Please try again.";
        }

        $stmt2->close();
    } else {
        // Email does not exist
        $error = "Email not found. Please try again.";
    }

    $stmt->close();
}
$conn->close();
?>

<!-- ------------------------------------------------------------ HTML ---------------------------------------------------------- -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="css/Navbar.css">
    <link rel="stylesheet" href="css/forgetpassword.css">
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
                    <li><a href="">CONTENT</a></li>
                    <li><a href="package.php">PACKAGES</a></li>
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

    ------------------------------------------------------Main Body Forgot Password Section ----------------------------------------------------------

    <section class="forgot-password-section fade-up">
        <h1>Forgot Password?</h1>

        <!-- Display an error or success message if it exists -->
        <?php if (!empty($error)): ?>
            <p class="alert <?php echo (strpos($error, 'OTP has been sent') !== false) ? 'alert-success' : 'alert-error'; ?>">
                <?php echo htmlspecialchars($error); ?>
            </p>
        <?php endif; ?>


        <form action="forgetpassword.php" method="POST">
            <label for="email">Enter your email address and we will send you OTP to reset your password.</label>
            <input type="email" id="email" name="email" placeholder="Email address" required>
            <div class="button-container">
                <button type="submit" name="submit">Confirm</button>
            </div>
            <a href="login.php" class="backlink" id="back-to-login">Back to Login Page</a>
        </form>

        <!-- ----------------------------------------------------- JavaScript to prevent multiple form submissions ------------------------------------------------------- -->
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const form = document.querySelector('form');
                const backToLoginLink = document.getElementById('back-to-login');
                const confirmButton = document.querySelector('button');

                form.addEventListener('submit', () => {
                    confirmButton.textContent = 'Processing...';
                    confirmButton.style.pointerEvents = 'none';
                    confirmButton.style.backgroundColor = 'gray';

                    backToLoginLink.style.pointerEvents = 'none';
                    backToLoginLink.style.color = 'gray';
                    backToLoginLink.textContent = 'Please wait...';

                    setTimeout(() => {
                        confirmButton.textContent = 'Confirm';
                        confirmButton.style.pointerEvents = 'auto';
                        confirmButton.style.backgroundColor = '';

                        backToLoginLink.style.pointerEvents = 'auto';
                        backToLoginLink.style.color = '';
                        backToLoginLink.textContent = 'Back to Login Page';
                    }, 5000);
                });
            });
        </script>

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

    <!-- ------------------------------------------------------ JavaScript ---------------------------------------------------------- -->

    <script src="js/smoothscroll.js"></script> // Smooth scroll About Us and Arrow
    <script src="js/scrollfade.js"></script> // Fade up content effect

    <!-- --------------------------------------------------------------------------------------------------------------------------- -->

</body>

</html>