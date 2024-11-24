<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NOS Insurance</title>
    <link rel="stylesheet" href="css/MainPage.css">
    <link rel="stylesheet" href="css/Navbar.css">
    <link rel="stylesheet" href="css/Footer.css">

</head>

<body>

    <?php
    session_start();
    require 'db_connection.php';


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // รับค่าจากฟอร์ม
        $policyID = $_POST['PolicyID'];
        $policyName = $_POST['PolicyName'];
        $policyType = $_POST['PolicyType'];
        $coverageAmount = $_POST['CoverageAmount'];
        $premium = $_POST['Premium'];
        $termLength = $_POST['TermLength'];
        $description = $_POST['Description'];

        // ตรวจสอบการอัปโหลดไฟล์
        if (isset($_FILES['Image']) && $_FILES['Image']['error'] === UPLOAD_ERR_OK) {
            $imageTmpPath = $_FILES['Image']['tmp_name'];
            $imageName = basename($_FILES['Image']['name']);
            $uploadDir = 'uploads/'; // โฟลเดอร์ที่เก็บรูปภาพ
            $imagePath = $uploadDir . $imageName;

            // ตรวจสอบว่ามีโฟลเดอร์ uploads หรือไม่
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true); // สร้างโฟลเดอร์ถ้ายังไม่มี
            }

            // ย้ายไฟล์ไปยังโฟลเดอร์เป้าหมาย
            if (move_uploaded_file($imageTmpPath, $imagePath)) {
                // เตรียมคำสั่ง SQL

                chmod($imagePath, 0755);

                $sql = " INSERT INTO policy (PolicyID, PolicyName, PolicyType, CoverageAmount, Premium, TermLength, Description, ImageName) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?) ";
                $stmt = $conn->prepare($sql);

                if ($stmt) {
                    // ผูกค่าตัวแปร
                    $stmt->bind_param("ssssssss", $policyID, $policyName, $policyType, $coverageAmount, $premium, $termLength, $description, $imageName);

                    // รันคำสั่ง SQL
                    if ($stmt->execute()) {
                        echo "เพิ่มแพ็กเกจสำเร็จ!";
                    } else {
                        echo "เกิดข้อผิดพลาด: " . $stmt->error;
                    }
                } else {
                    echo "เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL: " . $conn->error;
                }
            } else {
                echo "เกิดข้อผิดพลาดในการอัปโหลดไฟล์";
            }
        } else {
            echo "กรุณาอัปโหลดรูปภาพ!";
        }
    }
    ?>




    <!-- ---------------------------------------------------------- NavBar Section ---------------------------------------------------------- -->

    <nav>
        <div class="nav-container">
            <div class="left">
                <a href="index.php" class="logo"><img class="NOSlogo" src="images/NOSlogo.png" alt=""></a>
                <ul class="nav-links">
                    <li><a href="admindashboard.php" id="current_page">HOME</a></li>
                    <li><a href="">CONTENT</a></li>
                    <li><a href="package.php">PACKAGES</a></li>
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
    <!-- ------------------------------------------------------- Big Picture Section ---------------------------------------------------------- -->

    <div class="bigcontaintcontainer">
        <img src="images/background.png" class="backgroundimg">
        <div class="welcomebox">
            <h1 class="welcometext">Welcome back admin </h1>
            <button class="bigcontentbt">รายละเอียด</button>
        </div>

        <div class="scorlldot">
            <div class="dot" id="pic1"></div>
            <div class="dot" id="pic2"></div>
            <div class="dot" id="pic3"></div>
            <div class="dot" id="pic4"></div>
            <div class="dot" id="pic5"></div>
        </div>
    </div>

    <!-- ------------------------------------------------------- Main Content Section ---------------------------------------------------------- -->

    <form id="add-package-form" method="POST" action="admindashboard.php" enctype="multipart/form-data">

        <label for="PolicyName">Policy Name:</label>
        <input type="text" id="PolicyName" name="PolicyName" required>

        <label for="PolicyName">PolicyType:</label>
        <select id="PolicyType" name="PolicyType" required>
            <option value="" disabled selected>เลือกประเภท</option>
            <option value="Life">Life</option>
            <option value="Health">Health</option>
            <option value="Auto">Auto</option>
            <option value="Home">Home</option>
            <option value="Other">Other</option>

        </select>

        <label for="CoverageAmount">Coverage Amount:</label>
        <input type="text" id="CoverageAmount" name="CoverageAmount" required>

        <label for="Premium">Premium:</label>
        <input type="text" id="Premium" name="Premium" required>

        <label for="TermLength">Term Length:</label>
        <input type="text" id="TermLength" name="TermLength" required>

        <label for="Description">Description:</label>
        <textarea id="Description" name="Description" required></textarea>

        <label for="Image">Package Image:</label>
        <input type="file" id="Image" name="Image" accept="image/*" required>

        <button type="submit">บันทึกข้อมูล</button>
    </form>

    <!-- <label for="status">สถานะ:</label>
        <select id="status" name="status">
            <option value="draft">ร่าง</option>
            <option value="published">เผยแพร่</option>
        </select> -->


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