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
        <title>สิทธิประโยชน์สมาชิก</title>
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
                /* ระยะห่างระหว่างรูปภาพกับข้อความ */
            }

            .image-container {
                flex: 1;
                /* ทำให้ภาพปรับขนาดได้ */
            }

            .image-container img {
                width: 100%;
                /* ปรับภาพให้พอดีกับ container */
                border-radius: 10px;
                /* มุมมนของภาพ */
            }

            .text-container {
                flex: 2;
                /* ทำให้ข้อความกว้างกว่าภาพ */
            }

            .header {
                text-align: left;
                /* จัดข้อความชิดซ้าย */
                margin-bottom: 20px;
            }

            .header h1 {
                font-size: 2rem;
                color: #007bff;
            }

            .header p {
                font-size: 1.2rem;
                color: #555;
            }

            .benefits-list {
                margin: 20px 0;
                padding: 0;
                list-style: none;
            }

            .benefits-list li {
                margin-bottom: 15px;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <!-- รูปภาพ -->
            <div class="image-container">
                <img src="images/car.jpg" alt="Car Image">
            </div>

            <!-- ข้อความ -->
            <div class="text-container">
                <div class="header">
                    <h1>มีสิทธิประโยชน์มากมายสำหรับสมาชิก</h1>
                    <p>ทั้งอบรม สอบ และต่อใบอนุญาตประกันภัย พร้อมกิจกรรมพิเศษอื่นๆ ทั้งในประเทศและต่างประเทศ</p>
                </div>
                <ul class="benefits-list">
                    <li><strong>อบรมและสอบใบอนุญาตประกันภัย:</strong> เตรียมพร้อมการอบรมและจัดสอบเพื่อช่วยคุณพัฒนาทักษะในสายอาชีพประกันภัย</li>
                    <li><strong>สนับสนุนการต่ออายุใบอนุญาต:</strong> เราให้คำแนะนำและช่วยเหลือเพื่อความสะดวกสูงสุด</li>
                    <li><strong>ทรัพยากรเพื่อสร้างความเชี่ยวชาญ:</strong> เพิ่มผลิตภัณฑ์ที่ตอบโจทย์สำหรับตลาดประกันภัย</li>
                    <li><strong>โอกาสสัมมนาพิเศษในประเทศและต่างประเทศ:</strong> เพิ่มเครือข่ายและประสบการณ์พิเศษในสายงาน</li>
                    <li><strong>กิจกรรมส่งเสริมความรู้และเครือข่าย:</strong> เข้าร่วมเวิร์กช็อป และกิจกรรมเพื่อพัฒนาตนเอง</li>
                    <li><strong>พบปะและสร้างเครือข่าย:</strong> ขยายมุมมองใหม่ๆ จากการพบปะกับผู้ที่มีประสบการณ์</li>
                    <li><strong>สิทธิประโยชน์อื่นๆ:</strong> ส่วนลดและโปรโมชั่นพิเศษที่คัดสรรมาเพื่อคุณโดยเฉพาะ</li>
                    <li><strong>บริการสนับสนุนแบบส่วนตัว:</strong> มาร่วมเป็นส่วนหนึ่งของสังคมที่ให้ความสำคัญกับเป้าหมายของคุณ</li>
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
</body>

</html>