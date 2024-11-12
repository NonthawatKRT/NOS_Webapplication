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

    <!-- ------------------------------------------------------- Big Picture Section ---------------------------------------------------------- -->

    <div class="bigcontaintcontainer">
        <img src="images/packetbg.jpg" class="backgroundimg">

        <div class="scorlldot">
            <div class="dot" id="pic1"></div>
            <div class="dot" id="pic2"></div>
            <div class="dot" id="pic3"></div>
            <div class="dot" id="pic4"></div>
            <div class="dot" id="pic5"></div>
        </div>
    </div>

    <!-- ------------------------------------------------------- Main Content Section ---------------------------------------------------------- -->
    
    <div class="main-content">

        
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