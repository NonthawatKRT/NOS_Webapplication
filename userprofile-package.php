<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NOS Insurance</title>
    <link rel="stylesheet" href="css/Navbar.css">
    <link rel="stylesheet" href="css/PackageDetails.css">
    <link rel="stylesheet" href="css/Footer.css">

</head>

<body>
    <?php

    session_start();
    require 'db_connection.php';

    $sql = "SELECT * FROM users WHERE UserID = ?";
    $UserID = $_SESSION['UserID'];


    // ---------------- รับ ID จาก URL ในการเรียก package มาแสดง ----------------//
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $packageId = (int) $_GET['id'];

        //getuserID from logincredentials
        $username = $_SESSION['username'];
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

            $username = $_SESSION['username'];
            $getuserid = "SELECT CustomerID FROM customer WHERE email = '$username'";
            $result = $conn->query($getuserid);
            $row = $result->fetch_assoc();
            $UserID = $row['CustomerID'];


            $getstatus = "SELECT PaymentStatus FROM customerpolicy WHERE PolicyID = '$packageId' AND CustomerID = '$UserID'";
            $result = $conn->query($getstatus);
            $row = $result->fetch_assoc();
            $PaymentStatus = $row['PaymentStatus'];

            // ค้นหาข้อมูลแพ็คเกจจากฐานข้อมูล
            $sql = "SELECT * FROM policy WHERE PolicyID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $packageId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $package = $result->fetch_assoc();
            } else {
                echo "Package not found.";
                exit;
            }
            $sql = "SELECT * FROM customerpolicy WHERE PolicyID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $packageId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $packages = $result->fetch_assoc();
            } else {
                echo "Package not found.";
                exit;
            }
        }
        else{

           $username = $_SESSION['username'];
            $getuserid = "SELECT EmployeeID FROM employees WHERE email = '$username'";
            $result = $conn->query($getuserid);
            $row = $result->fetch_assoc();
            $UserID = $row['EmployeeID'];


            $getstatus = "SELECT PaymentStatus FROM employeepolicy WHERE PolicyID = '$packageId' AND EmployeeID = '$UserID'";
            $result = $conn->query($getstatus);
            $row = $result->fetch_assoc();
            $PaymentStatus = $row['PaymentStatus'];

            // ค้นหาข้อมูลแพ็คเกจจากฐานข้อมูล
            $sql = "SELECT * FROM policy WHERE PolicyID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $packageId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $package = $result->fetch_assoc();
            } else {
                echo "Package not found.";
                exit;
            }
            $sql = "SELECT * FROM employeepolicy WHERE PolicyID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $packageId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $packages = $result->fetch_assoc();
            } else {
                echo "Package not found.";
                exit;
            }


        }
    } else {
        echo "Invalid package ID.";
        exit;
    }

    if ($PaymentStatus === 'Paid' && $UserRole == 'Customer') {
        $getseleID = "SELECT SalesID FROM salescustomer WHERE CustomerID = '$UserID'";
        $result = $conn->query($getseleID);
        $row = $result->fetch_assoc();
        $SalesID = $row['SalesID'];

        $getempID = "SELECT EmployeeID FROM sales WHERE SalesID = '$SalesID'";
        $result = $conn->query($getempID);
        $row = $result->fetch_assoc();
        $EmployeeID = $row['EmployeeID'];

        $getsalecontact = "SELECT email,phonenumber FROM employees WHERE EmployeeID = '$EmployeeID'";
        $result = $conn->query($getsalecontact);
        $row = $result->fetch_assoc();
        $saleemail = $row['email'];
        $salephone = $row['phonenumber'];
    }

    ?>

    <!-- NavBar Section -->


    <nav>
        <div class="nav-container">
            <div class="left">
                <a href="index.php" class="logo"><img class="NOSlogo" src="images/NOSlogo.png" alt=""></a>
                <ul class="nav-links">
                    <li><a href="index.php">HOME</a></li>
                    <li><a href="content.php">CONTENT</a></li>
                    <li><a href="CS-package.php" id="current_page">PACKAGES</a></li>
                    <P style=" margin-top: 0px; margin-bottom: 0px; margin-right: 20px;"> | </P>
                    <li><a href="#">ABOUT US</a></li>
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

    <!-- Big Picture Section -->
    <div class="bigcontaintcontainer">
        <img src="images/packetbg.jpg" class="backgroundimg">
    </div>

    <a href="userprofile.php" class="back-button">Back to Packages</a>

    <!-- Main Content Section -->
    <div class="package-details fade-up">
        <img src="uploads/<?php echo htmlspecialchars($package['ImageName']); ?>" alt="Package Image">
        <div class="package-content">
            <h1><?php echo htmlspecialchars($package['PolicyName']); ?></h1>

            <?php if ($PaymentStatus === 'Paid') : ?>
                <p class="payment-status-paid">
                    Payment Completed
                </p>
            <?php endif; ?>
            <?php if ($PaymentStatus === 'Pending') : ?>
                <p class="payment-status-pending">
                    Pending Payment
                </p>
            <?php endif; ?>


            <p><strong>Type:</strong> <?php echo htmlspecialchars($package['PolicyType']); ?></p>
            <p><strong>Coverage:</strong> <?php echo htmlspecialchars($package['CoverageAmount']); ?> THB</p>
            <p><strong>Premium:</strong> <?php echo htmlspecialchars($package['Premium']); ?> THB</p>
            <p><strong>Term Length:</strong> <?php echo htmlspecialchars($package['TermLength']); ?> years</p>
            <p><?php echo htmlspecialchars($package['Description']); ?></p>

            <?php if ($PaymentStatus === 'Pending') : ?>
                <div class="buttoncontainer">
                    <form action="Cancle-enrolled.php?id=<?php echo $package['PolicyID']; ?>" method="POST">
                        <button type="submit" class="cancle-button">Remove Package</button>
                    </form>

                    <form action="CS-payment.php?id=<?php echo $package['PolicyID']; ?>" method="POST">
                        <!-- <input type="hidden" name="PolicyID" value="<?php echo $package['PolicyID']; ?>"> -->
                        <button type="submit" class="confirm-button">Confirm Payment</button>
                    </form>
                </div>
            <?php endif; ?>
            <?php if ($PaymentStatus === 'Paid' && $UserRole ==='Customer') : ?>
                <div class="salecontactcontainer">
                    <h3>Sale Contact</h3>
                    <p><span style="color:#0056b3; font-weight:bold;">Email:</span> <?php echo $saleemail; ?></p>
                    <p><span style="color:#0056b3; font-weight:bold;">Phone:</span> <?php echo $salephone; ?></p>
                    <p style="font-weight: bold;">*** Sale will contact you in 24hr. If not please contact us. ***</p>
                </div>
            <?php endif; ?>
        </div>
    </div>




    <!-- Footer Section  -->

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