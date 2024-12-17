<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/userdashboardforadmin.css">
    <link rel="stylesheet" href="css/Navbar.css">
    <link rel="stylesheet" href="css/Footer.css">
</head>

<body>
    <?php

    session_start();
    require 'db_connection.php';
    require_once 'switfmailer/vendor/autoload.php'; // SwiftMailer autoload

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];

        // Prepare SwiftMailer
        $transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
            ->setUsername('NonthawatForStudy@gmail.com')
            ->setPassword('ifre wgkn uknu ecox');

        // Disable certificate verification
        $transport->setStreamOptions([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ],
        ]);

        $mailer = new Swift_Mailer($transport);

        // Prepare the verification email
        $verification_link = "http://localhost/NOS_Webapplication/saleregister.php";
        $subject = "Online Enrollment";
        $bodycontent = "
                <html>
                    <head>
                        <style>
                            .email-container { font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 8px; text-align: center; }
                            .header { text-align: center; background-color: #7f878f; color: white; padding: 10px; border-radius: 8px 8px 0 0; }
                            .header img { max-width: 150px; margin-bottom: 4px; margin-top: 20px; }
                            .content { padding: 10px 20px 0px 20px; }
                            .content p { font-size: 16px; line-height: 1.6; color: #333; }
                            .btn { display: inline-block; padding: 10px 30px; font-size: 16px; background-color: #39a752; color: white; text-decoration: none; border-radius: 5px; margin-top: 5px; margin-bottom: 5px; }
                            .footer { text-align: center; padding: 10px; font-size: 12px; color: #999; display: flex; justify-content: space-between; margin-top: 0px; }
                            .footer div { margin: 5px 0; display: flex; }
                        </style>
                    </head>
                    <body>
                        <div class='email-container'>
                            <div class='header'>
                                <img src='https://drive.google.com/uc?export=view&id=171zpal8y6noIqEJ2uK6LPm7tmzY-2KxC' alt='Your Logo'>
                                <h1>Online Enrollment</h1>
                            </div>
                            <div class='content'>
                                <p><strong>Hello</strong>,</p>
                                <p>Please Click the button below and follow instructin to enroll</p>
                                <p><a href='$verification_link' class='btn'>Register</a></p>
                                <p>If the button above doesn't work, copy and paste the following link into your browser:</p>
                                <p><a href='$verification_link'>$verification_link</a></p>
                            </div>
                            <div class='footer'>
                                <div><p style='margin-right: 5px;'>Best regards,</p><p>Nonthawat For Study Team</p></div>
                                <div><p>&copy; 2024 Nonthawat For Study. All rights reserved.</p></div>
                            </div>
                        </div>
                    </body>
                </html>";

        // Create a message
        $message = (new Swift_Message($subject))
            ->setFrom(['NonthawatForStudy@gmail.com' => 'Nonthawat For Study'])
            ->setTo([$email => 'User'])
            ->setBody($bodycontent, 'text/html');

        $mailer->send($message); // Send the message

        echo "<script>alert('Email sent successfully!');</script>";
    }


    // Query for User Dashboard
    $userDashboardData = [];
    $userQuery = "SELECT 
    c.CustomerID, 
    CONCAT(c.FirstName, ' ', c.LastName) AS FullName, 
    lc.email, 
    lc.status,
    COUNT(cp.PolicyID) AS TotalPolicies
  FROM customer c
  INNER JOIN logincredentials lc ON c.CustomerID = lc.userID
  LEFT JOIN customerpolicy cp ON c.CustomerID = cp.CustomerID
  GROUP BY c.CustomerID";

    $result = $conn->query($userQuery);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $userDashboardData[] = $row;
        }
    }

    // Query for Employee Dashboard
    $employeeDashboardData = [];
    $employeeQuery = "SELECT 
                    e.EmployeeID, 
                    CONCAT(e.FirstName, ' ', e.LastName) AS FullName, 
                    lc.email, 
                    lc.status,
                    COUNT(sc.SalesID) AS TotalSales
                  FROM employees e
                  INNER JOIN logincredentials lc ON e.EmployeeID = lc.userID
                  LEFT JOIN sales sc ON e.EmployeeID = sc.EmployeeID
                  GROUP BY e.EmployeeID";

    $result = $conn->query($employeeQuery);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $employeeDashboardData[] = $row;
        }
    }

    $conn->close();
    ?>
    <!-- ---------------------------------------------------------- NavBar Section ---------------------------------------------------------- -->


    <nav>
        <div class="nav-container">
            <div class="left">
                <a href="admin-home.php" class="logo"><img class="NOSlogo" src="images/NOSlogo.png" alt=""></a>
                <ul class="nav-links">
                    <li><a href="admin_dashboard.php">HOME</a></li>
                    <li><a href="userdashboardforadmin.php" id="current_page">DASHBOARD</a></li>
                    <li><a href="admin-package.php">PACKAGES</a></li>
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
                        <a href="logout.php">
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


    <!-- ------------------------------------------------ Main Section ---------------------------------------------------------- -->

    <section class="enrollsection fade-up">
        <h1>Employee Enrollment</h1>
        <div class="enrollmentcontainer">
            <form action="userdashboardforadmin.php" method="POST">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <button type="submit" class="submitbt">Submit</button>
            </form>
        </div>
    </section>

    <!-- User Dashboard Section -->
    <section class="userdashboardsection fade-up">
        <h1>User Dashboard</h1>
        <div class="search-container">
            <label for="userSearch">Search Users:</label>
            <input type="text" id="userSearch" placeholder="Search by Name or Email">
        </div>
        <?php if (!empty($userDashboardData)): ?>
            <table id="userTable">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Total Policies</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($userDashboardData as $user): ?>
                        <tr onclick="window.location.href='admin-view-user.php?id=<?php echo $user['CustomerID']; ?>'">
                            <td><?php echo htmlspecialchars($user['CustomerID']); ?></td>
                            <td><?php echo htmlspecialchars($user['FullName']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['status']); ?></td>
                            <td><?php echo htmlspecialchars($user['TotalPolicies']); ?></td>
                        </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No user data found.</p>
        <?php endif; ?>
    </section>

    <!-- Employee Dashboard Section -->
    <section class="employeedashboardsection fade-up">
        <h1>Employee Dashboard</h1>
        <div class="search-container">
            <label for="employeeSearch">Search Employees:</label>
            <input type="text" id="employeeSearch" placeholder="Search by Name or Email">
        </div>
        <?php if (!empty($employeeDashboardData)): ?>
            <table id="employeeTable">
                <thead>
                    <tr>
                        <th>Employee ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Total Sales</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($employeeDashboardData as $employee): ?>
                        <tr onclick="window.location.href='admin-view-user.php?id=<?php echo $employee['EmployeeID']; ?>'">
                            <td><?php echo htmlspecialchars($employee['EmployeeID']); ?></td>
                            <td><?php echo htmlspecialchars($employee['FullName']); ?></td>
                            <td><?php echo htmlspecialchars($employee['email']); ?></td>
                            <td><?php echo htmlspecialchars($employee['status']); ?></td>
                            <td><?php echo htmlspecialchars($employee['TotalSales']); ?></td>
                        </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No employee data found.</p>
        <?php endif; ?>
    </section>

    <script>
        // Function to filter table data
        function filterTable(inputId, tableId) {
            const input = document.getElementById(inputId);
            const filter = input.value.toLowerCase();
            const table = document.getElementById(tableId);
            const rows = table.getElementsByTagName("tr");

            for (let i = 1; i < rows.length; i++) { // Skip the table header
                const cells = rows[i].getElementsByTagName("td");
                let rowMatch = false;

                for (let j = 0; j < cells.length; j++) {
                    const cellText = cells[j].textContent || cells[j].innerText;
                    if (cellText.toLowerCase().includes(filter)) {
                        rowMatch = true;
                        break;
                    }
                }

                rows[i].style.display = rowMatch ? "" : "none";
            }
        }

        // Attach event listeners for the search inputs
        document.getElementById("userSearch").addEventListener("input", function() {
            filterTable("userSearch", "userTable");
        });

        document.getElementById("employeeSearch").addEventListener("input", function() {
            filterTable("employeeSearch", "employeeTable");
        });
    </script>






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