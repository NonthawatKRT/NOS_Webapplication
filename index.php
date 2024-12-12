<!-- -------------------------------------------------------- Index Page ------------------------------------------------------
file use:
    require: MainPage.css
    require: Navbar.css
    require: Footer.css
    require: smoothscroll.js
    require: slideshow.js
    require: scrollFade.js
-------------------------------------------------------------------------------------------------------------------------- -->

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

    // Check if the session contains 'username' and if it equals 'admin'
    if (isset($_SESSION['username']) && $_SESSION['username'] === 'admin') {
        header('Location: admin_dashboard.php'); // Redirect to admin dashboard
        exit(); // Stop further execution to ensure proper redirection
    }

    ?>

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

    <!-- ------------------------------------------------------- Big Picture Section ---------------------------------------------------------- -->

    <div class="bigcontaintcontainer">
        <div class="slideshow-wrapper">
            <div class="slide" style="background-image: url('images/background.png');"></div>
            <div class="slide" style="background-image: url('images/background2.jpg');"></div>
            <div class="slide" style="background-image: url('images/background3.jpg');"></div>
            <div class="slide" style="background-image: url('images/background4.png');"></div>
            <div class="slide" style="background-image: url('images/background5.jpg');"></div>
        </div>

        <div class="welcomebox">
            <h1 class="welcometext fade-up">ประกันชีวิตที่คุณต้องการ <br> เริ่มต้นที่ x,xxx บาท</h1>
            <button class="bigcontentbt fade-up">รายละเอียด</button>
        </div>

        <div class="scorlldot">
            <div class="dot active"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
    </div>



    <!-- ------------------------------------------------------- Main Content Section ---------------------------------------------------------- -->

    <div class="main-content">

        <!-- -------------------------------------------------------- Ads Section ---------------------------------------------------------- -->

        <section class="ads fade-up">
            <h1>ประกันภัยเเละประกันชีวิต NOS Insurance</h1>
            <p>เลือกซื้อประกันภัยกับ NOS Insurance พร้อมรับสิทธิพิเศษมากมาย</p>
            <div class="line"></div>
        </section>

        <!-- ------------------------------------------------------ Benefits Section ---------------------------------------------------------- -->

        <section class="benefits fade-up">
            <div class="benefitsbox">
                <div class="benefitshead">
                    <p>เป็นสมาชิกกับ NOS Insurance ดีอย่างไร ?</p>
                </div>
                <div class="benefitscontent">
                    <div class="benefitsrow">
                        <img src="images/checkmark.png" alt="">
                        <div class="benefitsrowinfo">
                            <p class="benefitsrowtittle">สมัครง่ายเเละฟรี</p>
                            <p>ระบบสมัครง่ายภายใน 5 นาที ฟรีไม่มีค่าใช้ง่าย</p>
                        </div>
                    </div>

                    <div class="benefitsrow">
                        <img src="images/checkmark.png" alt="">
                        <div class="benefitsrowinfo">
                            <p class="benefitsrowtittle">ระบบใช้งานง่าย</p>
                            <p>เเค่เข้าสู่ระบบกดเช็คเบี้ยประกันก็พร้อมปิดการขายเพิ่มโอกาสการขายได้ทุกที่</p>
                        </div>
                    </div>

                    <div class="benefitsrow">
                        <img src="images/checkmark.png" alt="">
                        <div class="benefitsrowinfo">
                            <p class="benefitsrowtittle">บริหารฐานลูกค้าง่ายๆ</p>
                            <p>ด้วยระบบเเจ้งเตือนต่ออายุงานประกันของลูกค้าพร้อมทีมงานให้บริการดูเเลอย่างใกล้ชิด</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ------------------------------------------------------ Example Package Section ---------------------------------------------------------- -->

        <section class="examplepackage">
            <div class="packageinfo">
                <p>ตัวอย่างเเพ็คเกจ</p>
                <hr>
            </div>
            <div class="packagerow fade-up">
                <div class="packagecard">
                    <img src="images/Expackage1.png" alt="Package 1" class="packageimg">
                    <div class="packagecardinfo"></div>
                    <p class="packagetittle">รายละเอียดเเพ็คเกจ</p>
                    <div class="packagedetail">
                        <div class="packagedetailrow">
                            <p>คุ้มครองอุบัติเหตุ สูงสุด</p>
                            <p>1,000,000 บาท/ปี</p>
                        </div>
                        <div class="packagedetailrow">
                            <p>ค่ารักษาพยาบาล อุบัติเหตุ</p>
                            <p>50,000 บาท/ครั้ง</p>
                        </div>
                        <div class="packagedetailrow">
                            <p>ผลประโยชน์อุบัติเหตุสาธารณะ</p>
                            <p>1,000,000 บาท/ปี</p>
                        </div>
                        <div class="packagedetailrow">
                            <p>ชดเชยรายได้(สูงสุด30วัน)</p>
                            <p>0 บาท/วัน</p>
                        </div>
                        <div class="packagedetailrow">
                            <p>ค่าปลงศพ</p>
                            <p>50,000 บาท/ครั้ง</p>
                        </div>
                    </div>
                    <div class="packagebtcontainer">
                        <a href="" class="packagebt">สนใจ</a>
                    </div>
                </div>
                <div class="packagecard">
                    <img src="images/Expackage2.png" alt="Package 2" class="packageimg">
                    <div class="packagecardinfo">
                        <p class="packagetittle">รายละเอียดเเพ็คเกจ</p>
                        <div class="packagedetail">
                            <div class="packagedetailrow">
                                <p>คุ้มครองอุบัติเหตุ สูงสุด</p>
                                <p>1,000,000 บาท/ปี</p>
                            </div>
                            <div class="packagedetailrow">
                                <p>ค่ารักษาพยาบาล อุบัติเหตุ</p>
                                <p>100,000 บาท/ครั้ง</p>
                            </div>
                            <div class="packagedetailrow">
                                <p>ชดเชยรายได้ (สูงสุด 30วัน)</p>
                                <p>0 บาท/วัน</p>
                            </div>
                            <div class="packagedetailrow">
                                <p>ผลประโยชน์อุบัตเหตุ เพิ่มเติม</p>
                                <p>10,000 บาท/ครั้ง</p>
                            </div>
                            <div class="packagedetailrow">
                                <p>แข่งกีฬา ที่ไม่ใช่แบบมืออาชีพ</p>
                                <p>1,000,000 บาท/ปี</p>
                            </div>
                        </div>
                        <div class="packagebtcontainer">
                            <a href="" class="packagebt">สนใจ</a>
                        </div>
                    </div>
                </div>
                <a href="" class="packagemoredetailbt fade-up">SEE MORE</a>
            </div>
        </section>

        <!-- ------------------------------------------------------ Content Section ---------------------------------------------------------- -->

        <section class="contentsec">
            <div class="contents" style="margin-top: 10px; padding: 10px 25px;">
                <p style="font-size: 35px;font-weight: bold;margin-bottom: 10px;margin-left: 30px;">บทความเกี่ยวกับประกันภัย&ประกันชีวิต</p>
                <hr>
            </div>
            <div class="contentsrow fade-up">
                <div class="contentscard">
                    <div class="transparent"></div>
                    <img src="images/car.jpg" alt="Content 1" class="contentsimg">
                    <p>ประกันรถยนต์</p>
                </div>
                <div class="contentscard">
                    <div class="transparent"></div>
                    <img src="images/patient.png" alt="Content 2" class="contentsimg">
                    <p>ประกันสุขภาพ</p>
                </div>
                <div class="contentscard">
                    <div class="transparent"></div>
                    <img src="images/food.jpg" alt="Content 3" class="contentsimg">
                    <p>สิทธิพิเศษอื่นๆ</p>
                </div>
            </div>
            <div class="contentsbtcontainer">
                <a href="" class="contentsbt fade-up">SEE MORE</a>
            </div>
        </section>

        <!-- -------------------------------------------------- Question Section ---------------------------------------------------------- -->

        <section class="questionsec">
            <div class="questioninfo">
                <p>คำถามที่พบบ่อย</p>
                <hr>
            </div>
            <div class="questionrow">
                <div class="questioncard fade-up">
                    <div class="text">ซื้อประกันสุชภาพออนไลน์ VS ซื้อกับตัวเเทน เเบบไหนคุ้มกว่า </div>
                    <img src="images/plusicon.png" alt="" class="plusicon">
                </div>
            </div>
        </section>
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

    <script src="js/smoothscroll.js"></script>
    <script src="js/slideshow.js"></script>
    <script src="js/scrollFade.js"></script>



</body>

</html>