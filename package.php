<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NOS Insurance</title>
    <link rel="stylesheet" href="css/Package.css">
    <link rel="stylesheet" href="css/Navbar.css">
    <link rel="stylesheet" href="css/Footer.css">

</head>

<body>
    <?php
    require 'db_connection.php';
    session_start();
    $sql = "SELECT * FROM policy";
    $result = $conn->query($sql); // รันคำสั่ง SQL

    chmod($imagePath, 0755);

    $imagePath = 'uploads/' . htmlspecialchars($package['ImageName']);

    if (!file_exists($imagePath)) {
        echo "<p>File not found: $imagePath</p>";
    } else {
        echo "<p>File found: $imagePath</p>";
    }

    if ($result->num_rows > 0) {
        // เก็บข้อมูลใน array เพื่อแสดงผล
        $packages = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $packages = []; // ไม่มีข้อมูลในตาราง
    }

    // กำหนดจำนวนรายการต่อหน้า
    $limit = 6;

    // ตรวจสอบว่ามี page parameter หรือไม่
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    // คำนวณตำแหน่งเริ่มต้น
    $offset = ($page - 1) * $limit;

    // ดึงข้อมูลรายการจากฐานข้อมูล (ใช้ LIMIT และ OFFSET)
    $sql = "SELECT * FROM policy LIMIT $offset, $limit";
    $result = $conn->query($sql);

    // เก็บข้อมูลใน array
    $packages = $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : [];

    // ดึงจำนวนรายการทั้งหมด
    $total_result = $conn->query("SELECT COUNT(*) as total FROM policy");
    $total = $total_result->fetch_assoc()['total'];

    // คำนวณจำนวนหน้าทั้งหมด
    $total_pages = ceil($total / $limit);

    ?>

    <!-- ---------------------------------------------------------- NavBar Section ---------------------------------------------------------- -->

    <nav>
        <div class="nav-container">
            <div class="left">
                <a href="index.php" class="logo"><img class="NOSlogo" src="images/NOSlogo.png" alt=""></a>
                <ul class="nav-links">
                    <li><a href="index.php">HOME</a></li>
                    <li><a href="">CONTENT</a></li>
                    <li><a href="package.php" id="current_page">PACKAGES</a></li>
                    <P style=" margin-top: 0px; margin-bottom: 0px; margin-right: 20px;"> | </P>
                    <li><a href="">ABOUT US</a></li>
                </ul>
            </div>
            <div class="right">
                <!-- <a href="" class="contact"><img src="https://media-public.canva.com/MADpju8igYE/1/thumbnail.png" alt="" class="contactlogo"></a> -->
                <a href="" class="contact"><img src="images/searchicon.png" alt="" class="searchlogo"></a>
                <?php if (isset($_SESSION['username'])): ?>
                    <li class="loginbtcontainer"><a href="logout.php"
                            class="loginbt"><?php echo $_SESSION['username'] ?></a></li>
                <?php else: ?>
                    <li class="loginbtcontainer"><a href="login.php" class="loginbt">Login</a></li>
                <?php endif; ?>
                <!-- <a href="" class="languagebt">EN/TH</a> -->
            </div>
        </div>
    </nav>

    <!- ------------------------------------------------------- Big Picture Section ---------------------------------------------------------- -->
        <div class="bigcontaintcontainer">
            <img src="images/packetbg.jpg" class="backgroundimg">
        </div>

        <!--------------------------------------------------------- Main Content Section ---------------------------------------------------------- -->

        <div class="main-content">
            <div class="titlePackage">
                <h1>NOS Insurance Packages</h1>
            </div>
        <!--------------------------------------------------------- Package card Section ---------------------------------------------------------- -->

            <div class="package-container">
                <?php if (count($packages) > 0): ?>
                    <?php foreach ($packages as $package): ?>
                        <div class="package-card">
                            <img src="uploads/<?php echo htmlspecialchars($package['imageName']); ?>" alt="Package Image">
                            <h2><?php echo htmlspecialchars($package['PolicyName']); ?></h2>
                            <p>Type: <?php echo htmlspecialchars($package['PolicyType']); ?></p>
                            <p>Coverage: <?php echo htmlspecialchars($package['CoverageAmount']); ?> THB</p>
                                <p>Premium: <?php echo htmlspecialchars($package['Premium']); ?> THB</p>
                                <p>Term: <?php echo htmlspecialchars($package['TermLength']); ?> years</p>
                                <p><?php echo htmlspecialchars($package['Description']); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No packages available at the moment. Please check back later.</p>
                <?php endif; ?>
            </div>

            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?page=<?php echo $page - 1; ?>" class="prev-button">Previous</a>
                <?php endif; ?>

                <span>Page <?php echo $page; ?> of <?php echo $total_pages; ?></span>

                <?php if ($page < $total_pages): ?>
                    <a href="?page=<?php echo $page + 1; ?>" class="next-button">Next</a>
                <?php endif; ?>
            </div>
        </div>

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
</body>

</html>