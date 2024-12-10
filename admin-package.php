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

    $imagePath = 'uploads/' . htmlspecialchars($package['imageName']);

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

    $searchType = isset($_GET['search-type']) ? trim($_GET['search-type']) : '';
    $searchPrice = isset($_GET['search-price']) ? (int)$_GET['search-price'] : 0;

    // Pagination settings
    $limit = 6;
    $page = isset($_GET['page']) ? max((int)$_GET['page'], 1) : 1;
    $offset = ($page - 1) * $limit;

    // Base SQL
    $sql = "SELECT * FROM policy WHERE 1=1";
    $params = [];

    if (!empty($searchType)) {
        $sql .= " AND PolicyType = ?";
        $params[] = $searchType;
    }
    if ($searchPrice > 0) {
        $sql .= " AND Premium <= ?";
        $params[] = $searchPrice;
    }

    // Pagination
    $sql .= " LIMIT ?, ?";
    $params[] = $offset;
    $params[] = $limit;

    $stmt = $conn->prepare($sql);
    $param_types = str_repeat("s", count($params) - 2) . "ii"; // แยก string และ integer
    $stmt->bind_param($param_types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    $packages = $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : [];

    // Count total rows for pagination
    $sqlCount = "SELECT COUNT(*) as total FROM policy WHERE 1=1";
    if (!empty($searchType)) {
        $sqlCount .= " AND PolicyType = ?";
    }
    if ($searchPrice > 0) {
        $sqlCount .= " AND Premium <= ?";
    }

    $stmtCount = $conn->prepare($sqlCount);
    $stmtCount->bind_param(str_repeat("s", count($params) - 2), ...array_slice($params, 0, -2));
    $stmtCount->execute();
    $countResult = $stmtCount->get_result();
    $total = $countResult->fetch_assoc()['total'];
    $total_pages = ceil($total / $limit);

    function createPageUrl($page)
    {
        $queryParams = $_GET;
        $queryParams['page'] = $page;
        return htmlspecialchars("?" . http_build_query($queryParams));
    }
    ?>

    <!- NavBar Section ->

        <nav>
            <div class="nav-container">
                <div class="left">
                    <a href="admin-home.php" class="logo"><img class="NOSlogo" src="images/NOSlogo.png" alt=""></a>
                    <ul class="nav-links">
                        <li><a href="admin-home.php">HOME</a></li>
                        <li><a href="">CONTENT</a></li>
                        <li><a href="admin-package.php" id="current_page">PACKAGES</a></li>
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

        <!- Big Picture Section ->
            <div class="bigcontaintcontainer">
                <img src="images/packetbg.jpg" class="backgroundimg">
            </div>

            <!-- Main Content Section -->
            <div class="main-content">
                <div class="titlePackage">
                    <h1>NOS Insurance Packages</h1>
                </div>

                <!-- Search Section -->
                <div class="search">
                    <form method="GET" action="" class="search-form">
                        <label for="search-type">Policy Type:</label>
                        <select name="search-type" id="search-type">
                            <option value="" <?= $searchType === '' ? 'selected' : '' ?>>All</option>
                            <option value="Health" <?= $searchType === 'Health' ? 'selected' : '' ?>>Health</option>
                            <option value="Life" <?= $searchType === 'Life' ? 'selected' : '' ?>>Life</option>
                            <option value="Travel" <?= $searchType === 'Travel' ? 'selected' : '' ?>>Travel</option>
                        </select>

                        <label for="search-price">Max Premium (THB):</label>
                        <input type="number" name="search-price" id="search-price" placeholder="Enter max premium"
                            value="<?= htmlspecialchars($searchPrice) ?>">

                        <button type="submit">Search</button>
                    </form>
                </div>

                <!-- Package Cards Section -->
                <div class="package-container">
                    <?php if (!empty($packages)): ?>
                        <?php foreach ($packages as $package): ?>
                            <div class="package-card">
                                <a href="admin-package-details.php?id=<?php echo htmlspecialchars($package['PolicyID']); ?>">
                                    <img src="uploads/<?php echo htmlspecialchars($package['imageName']); ?>" alt="Package Image">
                                    <h2><?php echo htmlspecialchars($package['PolicyName']); ?></h2>
                                    <p><strong>Type:</strong> <?php echo htmlspecialchars($package['PolicyType']); ?></p>
                                    <p><strong>Coverage: </strong><?php echo htmlspecialchars($package['CoverageAmount']); ?> THB</p>
                                    <p><strong>Premium:</strong> <?php echo htmlspecialchars($package['Premium']); ?> THB</p>
                                    <p><strong>Term:</strong> <?php echo htmlspecialchars($package['TermLength']); ?> years</p>

                                    <!-- คำอธิบายแบบย่อ -->
                                    <div class="description">
                                        <?php
                                        $description = htmlspecialchars($package['Description']);
                                        if (strlen($description) > 150):
                                        ?>
                                            <p><?php echo substr($description, 0, 150); ?> <br><br> <strong class="read-more"> >อ่านเพิ่มเติม< </strong> </p>
                                        <?php else: ?>
                                            <p><?php echo $description; ?></p>
                                        <?php endif; ?>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <p>No packages available at the moment. Please check back later.</p>
                    <?php endif; ?>
                </div>

                <!-- Pagination Section -->
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="<?php echo createPageUrl($page - 1); ?>" class="prev-button">Previous</a>
                    <?php endif; ?>
                    <span>Page <?php echo $page; ?> of <?php echo $total_pages; ?></span>
                    <?php if ($page < $total_pages): ?>
                        <a href="<?php echo createPageUrl($page + 1); ?>" class="next-button">Next</a>
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