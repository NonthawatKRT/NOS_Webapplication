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
    <!DOCTYPE html>
    <html lang="th">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>เปรียบเทียบค่าเบี้ยประกัน</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                line-height: 1.6;
                background-color: #f9f9f9;
                color: #333;
            }

            .container {
                max-width: 1200px;
                margin: 50px auto;
                padding: 20px;
                display: flex;
                align-items: flex-start;
                gap: 20px;
            }

            .image-container {
                flex: 1;
            }

            .image-container img {
                width: 100%;
                border-radius: 10px;
            }

            .text-container {
                flex: 2;
            }

            .text-container h1 {
                font-size: 2rem;
                color: #007bff;
            }

            .text-container p {
                font-size: 1.2rem;
                color: #555;
            }

            .text-container ul {
                padding: 0;
                list-style: none;
            }

            .text-container ul li {
                margin-bottom: 10px;
                line-height: 1.6;
            }

            .text-container ul li strong {
                margin-bottom: 15px;
            }
        </style>
    </head>

    <body>
        <div class="container fade-up">
            <!-- รูปภาพ -->
            <div class="image-container">
                <img src="images/patient.png" alt="pateint Image">
            </div>

            <!-- ข้อความ -->
            <div class="text-container">
                <h1>เปรียบเทียบค่าเบี้ยประกันกว่า 16 บริษัทได้ทันที</h1>
                <p>ไม่ต้องเสียเวลาหาเบี้ยทีละบริษัท กดครั้งเดียวรู้เบี้ยหมด ครบทุกบริษัท!</p>
                <ul>
                    <li><strong>ครบทุกบริษัทในที่เดียว:</strong> เปรียบเทียบค่าเบี้ยประกันจากกว่า 16 บริษัทชั้นนำในประเทศไทย</li>
                    <li><strong>รวดเร็วและง่ายดาย:</strong> ไม่ต้องเสียเวลาเช็คทีละบริษัท กดเพียงครั้งเดียวรู้ผล</li>
                    <li><strong>โปร่งใสและเชื่อถือได้:</strong> ข้อมูลทั้งหมดได้รับการตรวจสอบและละเอียดที่สุด</li>
                    <li><strong>ช่วยให้คุณตัดสินใจได้ดีขึ้น:</strong> ค้นหาแผนที่เหมาะสมที่สุดสำหรับคุณ</li>
                </ul>
            </div>
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

    <script src="js/smoothscroll.js"></script>
    <script src="js/scrollFade.js"></script>

</body>

</html>