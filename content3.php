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
        <img src="images/background2.jpg" class="backgroundimg">
    </div>


    <!-- ------------------------------------------------------- Main Content Section ---------------------------------------------------------- -->


    <!DOCTYPE html>
    <html lang="th">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>โบนันซ่าเพิ่มรายได้พิเศษ</title>
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

            h1 {
                font-size: 2rem;
                color: #007bff;
            }

            h2 {
                /* c font-size: 1 rem; */
                color: #555;
            }

            p {
                line-height: 1.8;
                font-size: 1rem;
            }

            ul {
                padding-left: 20px;
            }

            ul li {
                margin-bottom: 10px;
                list-style: none;
            }
        </style>
    </head>

    <body>
        <div class="container fade-up">
            <div class="image-container">
                <img src="images/food.jpg" alt="food">
            </div>
            <div class="text-container">
                <h1>โบนัสเพิ่มรายได้พิเศษ</h1>
                <h2>ด้วยโปรแกรมแนะนำเพื่อนรับค่าตอบแทนแบบไม่จำกัด</h2>
                <p>
                    เพิ่มรายได้พิเศษง่ายๆ ด้วยโปรแกรมแนะนำเพื่อน
                    โอกาสสร้างรายได้เสริมมาถึงแล้ว!
                    เราเปิดโอกาสให้คุณสามารถสร้างรายได้พิเศษแบบไม่จำกัด ด้วยการเข้าร่วมโปรแกรมแนะนำเพื่อน ที่ทั้งง่ายและคุ้มค่า
                </p>
                <p><strong>โปรแกรมแนะนำเพื่อนทำงานอย่างไร?</strong></p>
                <ul>
                    <li>แนะนำเพื่อนหรือคนรู้จัก</li>
                    <li>ส่งต่อคำแนะนำเกี่ยวกับบริการประกันของเราให้กับคนที่คุณรู้จัก</li>
                    <li>เมื่อพวกเขาสมัครหรือซื้อประกันผ่านคุณ รับค่าตอบแทนทันที!</li>
                </ul>
                <p><strong>ข้อดีของการเข้าร่วมโปรแกรม:</strong></p>
                <ul>
                    <li>เพิ่มรายได้พิเศษ โดยไม่กระทบงานหลัก</li>
                    <li>รับโบนัส ตามยอดการแนะนำสำเร็จทันที</li>
                    <li>โอกาสร่วมกิจกรรมพิเศษและรางวัลเพิ่มเติม</li>
                </ul>
                <p>
                    ใครสามารถเข้าร่วมได้?
                    ไม่ว่าคุณจะเป็นใคร สามารถเข้าร่วมโปรแกรมนี้ได้ง่ายๆ เพียงสมัครเป็นสมาชิกกับเรา
                    เปลี่ยนการแนะนำเป็นรายได้พิเศษทันที!
                </p>
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