<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Life Insurance Main Page</title>
    <link rel="stylesheet" href="css/MainPage.css">
</head>
<body>
    <?php
    session_start();
    ?>

    <!-- Navigation Bar -->
    <nav>
    <div class="nav-container">
        <div class="left">
            <a href="index.php" class="logo" style="padding:10px;">NOS Insurance</a>
            <ul class="nav-links">
                <li><a href="index.php">HOME</a></li>
                <li><a href="">CONTENT</a></li>
                <li><a href="">PACKAGES</a></li>
                <P style="margin-left: 20px; margin-top: 0px; margin-bottom: 0px;"> | </P>
                <li><a href="">ABOUT US</a></li>
            </ul>
        </div>
        <div class="right">
            <a href="" class="contact"><img src="https://media-public.canva.com/MADpju8igYE/1/thumbnail.png" alt="" class="contactlogo"></a>
            <a href="" class="contact"><img src="https://media-public.canva.com/pz2bs/MAETCKpz2bs/1/t.png" alt="" class="searchlogo"></a>
            <?php if (isset($_SESSION['username'])): ?>
                <li class="loginbtcontainer"><a href="logout.php" class="loginbt"><?php echo $_SESSION['username'] ?></a></li>
            <?php else: ?>
                <li class="loginbtcontainer"><a href="login.php" class="loginbt">Login/Sign in</a></li>
            <?php endif; ?>
            <!-- <a href="" class="languagebt">EN/TH</a> -->
        </div>
    </div>
</nav>

    <div class="bigcontaintcontainer">
        <img src="images/Editedpagebg2.jpg" class="backgroundimg">
        <div class="welcomebox">
        <h1 class="welcometext">ประกันชีวิตที่คุณต้องการ <br> เริ่มต้นที่ 2,000 บาท**</h1>
        <button class="bigcontentbt">รายละเอียด</button>
        </div>
        
    </div>
    

    <!-- Main Content -->
    <div class="main-content">
        <section class="features">
            <div class="feature">
            <div class="firstbox">
                <img src="images/mainpagebg.jpg" alt="" class="boximg">
                <p class="boxtittle">Content</p>
            </div>
            <div class="secondbox">
            <img src="images/mainpagebg2.jpg" alt="" class="boximg">
            <p class="boxtittle">Content</p>
            </div>
            <div class="thirdbox">
            <img src="images/mainpagebg3.jpg" alt="" class="boximg">
                <p class="boxtittle">Content</p>
            </div>
            </div>
        </section>

            <div class="info">
                <h2>-- Suggest Package --</h2>
            </div>
            <div class="packagerow">
                <div class="packagecard">
                    <img src="images/package1.png" alt="Package 1" class="packageimg">
                    <h3>Package 1</h3>
                    <p>Details about Package 1</p>
                    <a href="">More info --> </a>
                </div>
                <div class="packagecard">
                    <img src="images/package2.png" alt="Package 2" class="packageimg">
                    <h3>Package 2</h3>
                    <p>Details about Package 1</p>
                    <a href="">More info --> </a>
                </div>
            </div>


        <section class="ads">
            <h2>Insurance Packages</h2>
            <div class="ads-container">
                <div class="ad">
                    <img src="images/package1.png" alt="Package 1">
                    <h3>Package 1</h3>
                    <p>Details about Package 1</p>
                    <?php if (isset($_SESSION['username'])): ?>
                        <a href="buy_package.php?package=package1">Buy Now</a>
                    <?php else: ?>
                        <a href="login2.php?redirect=buy_package.php?package=package1">Log in to buy this package</a>
                    <?php endif; ?>
                </div>
                <div class="ad">
                    <img src="images/package2.png" alt="Package 2">
                    <h3>Package 2</h3>
                    <p>Details about Package 2</p>
                    <?php if (isset($_SESSION['username'])): ?>
                        <a href="buy_package.php?package=package2">Buy Now</a>
                    <?php else: ?>
                        <a href="login2.php?redirect=buy_package.php?package=package2">Log in to buy this package</a>
                    <?php endif; ?>
                </div>
                <!-- Add more packages as needed -->
            </div>
        </section>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2024 Life Insurance Company. All rights reserved.</p>
    </div>
</body>
</html>
