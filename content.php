<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NOS Insurance</title>
    <link rel="stylesheet" href="css/package.css">
    <link rel="stylesheet" href="css/Navbar.css">
    <link rel="stylesheet" href="css/Footer.css">

</head>
<body>
    <?php
    session_start();
    ?>

    <!-- ---------------------------------------------------------- NavBar Section ---------------------------------------------------------- -->

    <nav>
        <div class="nav-container">
            <div class="left">
                <a href="index.php" class="logo"><img class="NOSlogo" src="images/NOSlogo.png" alt=""></a>
                <ul class="nav-links">
                    <li><a href="index.php">HOME</a></li>
                    <li><a href="content.php" id="current_page">CONTENT</a></li>
                    <li><a href="CS-package.php">PACKAGES</a></li>
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
        <img src="images/background2.jpg" class="backgroundimg">
    </div>

    <!-- ------------------------------------------------------- Main Content Section ---------------------------------------------------------- -->
    
    <div class="main-content">

        
    </div>
  <!-- ----------------------------------------------------------block------------------------------------ -->  
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ตัวอย่างกรอบ</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .card {
            display: flex;
            align-items: center;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 10px 0;
            width: 80%;
            max-width: 900px;
        }
        .card img {
            width: 150px;
            height: auto;
            border-radius: 10px;
            margin-right: 20px;
        }
        .card-content {
            flex: 1;
        }
        .card-content h3 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }
        .card-content p {
            margin: 10px 0 0;
            color: #555;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="card">
    <a href = "content1.php">
        <img src="images/car.jpg" alt="Car">
        <div class="card-content">
            <h3>มีสิทธิประโยชน์มากมาย</h3>
            <p>ทั้งอบรมสอบ และต่อใบอนุญาตประกันภัย รวมถึงทริปท่องเที่ยวต่างประเทศและอื่นๆ อีกมากมาย</p>
        </div>
    </a>
    </div>

    <div class="card">
    <a href = "content2.php">
        <img src="images/patient.png" alt="Patient">
        <div class="card-content">
            <h3>เปรียบเทียบค่าเบี้ยประกันกว่า 16 บริษัทได้ทันที</h3>
            <p>ไม่ต้องเสียเวลาหาที่เดียวนำเสนอครบทุกบริษัท</p>
        </div>
        </a>
    </div>

    <div class="card">
    <a href = "content3.php">
        <img src="images/food.jpg" alt="Food">
        <div class="card-content">
            <h3>โบนัสเพิ่มรายได้พิเศษ</h3>
            <p>ด้วยโปรแกรมแนะนำเพื่อน รับค่าตอบแทนแบบไม่จำกัด</p>
        </div>
         </a>
    </div>
</body>
</html>



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