<!-- ---------------------------------------------------- Login Page ----------------------------------------------------------
file use:
    required: db_connection.php
    required: Navbar.css
    required: Footer.css
    required: login.css
    required: smoothscroll.js
    required: scrollfade.js
----------------------------------------------------------------------------------------------------------------------------- -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/Navbar.css">
    <link rel="stylesheet" href="css/Footer.css">
</head>

<body>

    <!-- ------------------------------------------------------- BackEnd Section ---------------------------------------------------------- -->

    <?php
    require 'db_connection.php';
    // Start the session
    session_start();

    $error = '';

    if (isset($_POST['submit'])) {
        $Email = trim($_POST['username']);
        $Password = $_POST['password'];
        $error = ""; // Initialize error message

        // Hardcoded admin login (not recommended)
        if ($Email === 'admin' && $Password === 'adminoat') {
            $_SESSION['username'] = $Email;
            $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'admin_dashboard.php';
            header("Location: $redirect");
            exit();
        }

        // Hardcoded cpe888 login (not recommended)
        if ($Email === 'cpe888' && $Password === '123456789') {
            $_SESSION['username'] = $Email;
            $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'code888.php';
            header("Location: $redirect");
            exit();
        }

        // Fetch user data from the database
        $stmt = $conn->prepare("SELECT PasswordHash, status, userID FROM logincredentials WHERE email = ?");
        $stmt->bind_param("s", $Email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $storedHash = $row['PasswordHash'];
            $status = $row['status'];
            $userID = $row['userID'];

            // Fetch UserRole from the users table
            $stmt2 = $conn->prepare("SELECT UserRole FROM users WHERE userID = ?");
            $stmt2->bind_param("s", $userID);
            $stmt2->execute();
            $result2 = $stmt2->get_result();
            $row2 = $result2->fetch_assoc();
            $UserRole = $row2['UserRole'] ?? null; // Ensure a default value if UserRole is missing

            if ($UserRole === 'Customer') {
                if (password_verify($Password, $storedHash)) {
                    // Check if user is verified
                    if ($status === 'Active') {
                        $error = "You are a customer. Please login from the customer login page.";
                    } else {
                        $error = "Your email is not verified. Please check your inbox for the verification email.";
                    }
                } else {
                    $error = "Incorrect username or password.";
                }
            } elseif ($UserRole === 'Employee') {
                // Verify password
                if (password_verify($Password, $storedHash)) {
                    // Check if user is verified
                    if ($status === 'Active') {
                        $_SESSION['username'] = $Email;
                        $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'index.php';
                        header("Location: $redirect");
                        exit();
                    } else {
                        $error = "Your email is not verified. Please check your inbox for the verification email.";
                    }
                } else {
                    $error = "Incorrect username or password.";
                }
            } else {
                $error = "Invalid user role. Please contact support.";
            }
        } else {
            $error = "Incorrect username or password.";
        }

        $stmt->close();
    }

    // Close database connection
    $conn->close();
    ?>

    <!-- ---------------------------------------------------------- NavBar Section ---------------------------------------------------------- -->

    <nav>
        <div class="nav-container">
            <div class="left">
                <a href="index.php" class="logo"><img class="NOSlogo" src="images/NOSlogo.png" alt=""></a>
                <ul class="nav-links">
                    <li><a href="index.php">HOME</a></li>
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

    <!-- ------------------------------------------------------ Main Section ---------------------------------------------------------- -->

    <section class="mainloginsection">

        <div class="spacer">
            <!-- Display normal space if there's no error -->
            <?php if (!$error): ?>
                <div class="normalspace"></div>
            <?php endif; ?>
            <!-- Display the error message if it exists -->
            <?php if ($error == "Wrong username/password combination"): ?>
                <p class="alerttext">Wrong username/password combination</p>
            <?php endif; ?>
            <?php if ($error == "Your email is not verified. Please check your inbox for the verification email."): ?>
                <p class="alerttext">Your email is not verified. Please check your inbox for the verification email.</p>
            <?php endif; ?>
            <?php if ($error == "Incorrect username or password."): ?>
                <p class="alerttext">Incorrect username or password.</p>
            <?php endif; ?>
            <?php if ($error == "Invalid user role. Please contact support."): ?>
                <p class="alerttext">Invalid user role. Please contact support.</p>
            <?php endif; ?>
            <?php if ($error == "You are a customer. Please login from the customer login page."): ?>
                <p class="alerttext">You are a customer. Please login from the customer login page.</p>
            <?php endif; ?>

        </div>

        <div class="loginsection">
            <div class="leftsection fade-up">
                <p class="welcometext">Welcome To NOS Insuranse</p>
                <a href="login.php" class="salesloginbt">Customer Login</a>
            </div>
            <div class="rightsection">
                <p class="logintittle">LOG IN</p>
                <form action="saleslogin.php" method="post" class="formsection">
                    <label for="username">USERNAME</label>
                    <input type="text" id="username" name="username" required>
                    <label for="password">PASSWORD</label>
                    <input type="password" id="password" name="password" required>
                    <a href="forgetpassword.php" class="forgotpasswordbt">Forget password?</a>
                    <input type="submit" name="submit" value="Login">
                </form>
            </div>
        </div>

        <div class="bigcontaintcontainer">
            <img src="images/loginbg.jpg" class="backgroundimg">
            <div class="welcomebox">
                <h1 class="bgtext">"ปกป้อง<span style="color: #f6e000">ครอบครัว</span>ที่คุณรัก<br>สร้างความมั่นคงให้อนาคต"</h1>
            </div>
        </div>
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