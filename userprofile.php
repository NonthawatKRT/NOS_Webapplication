<!DOCTYPE html>
<html>

<head>
    <title>Profile</title>
    <link rel="stylesheet" href="css/Userprofile.css">
    <link rel="stylesheet" href="css/Navbar.css">
    <link rel="stylesheet" href="css/Footer.css">
</head>

<body>

    <?php
    require 'db_connection.php';
    session_start();

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    if (!isset($_SESSION['username'])) {
        echo "<script>
            alert('Cannot load user data. Please try again later.');
            window.location.href = 'login.php';
        </script>";
        exit();
    }

    // Check if user is logged in and session variables exist
    if (!isset($_SESSION['username'])) {
        echo json_encode(['success' => false, 'error' => 'User not logged in']);
        echo "<script>
            alert('Cannot load user data. Please try again later.');
            window.location.href = 'login.php';
        </script>";
        exit();
    }

    // Check if there's a success or error message to display
    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        $messageType = $_SESSION['message_type']; // success or error
        unset($_SESSION['message']); // Clear the message after displaying
        unset($_SESSION['message_type']); // Clear message type
    }


    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['Image'])) {
        $uploadDir = 'userprofiles/'; // Directory to store profile pictures

        // Ensure the directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Create the directory if it doesn't exist
        }

        $imageTmpPath = $_FILES['Image']['tmp_name'];
        $imageName = $_SESSION['username'] . ".png"; // Use username as the image name
        $imagePath = $uploadDir . $imageName;

        // Delete the existing file if it exists
        if (file_exists($imagePath)) {
            unlink($imagePath); // Remove the old file
        }

        // Move the uploaded file to the target directory
        if (move_uploaded_file($imageTmpPath, $imagePath)) {
            echo json_encode(['success' => true, 'message' => 'Profile picture updated successfully']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to upload profile picture']);
        }
    } else {
        // echo json_encode(['success' => false, 'error' => 'Invalid request or no file uploaded']);
    }

    // ดึงค้าของ customerID
    $Email = $_SESSION['username'] ?? null;
    $stmt = $conn->prepare("SELECT CustomerID FROM customer WHERE email = ?");
    $stmt->bind_param("s", $Email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userID = $row['CustomerID']; // Assign the retrieved CustomerID
        $_SESSION['CustomerID'] = $userID; // Update session

    } else {
        echo "<script>alert('Please log in.'); window.location.href = 'login.php';</script>";
        exit;
    }

    // $userID = $_SESSION['CustomerID'];
    // $stmt = $conn->prepare("SELECT PolicyID FROM customerpolicy WHERE CustomerID = ?");
    // $stmt->bind_param("s", $userID);
    // $stmt->execute();
    // $result = $stmt->get_result();
    // if ($result->num_rows > 0) {
    //     $row = $result->fetch_assoc();
    //     $CSpackage = $row['PolicyID']; // Assign the retrieved CustomerID
    //     $_SESSION['PolicyID'] = $CSpackage; // Update session

    // } else {
    //     echo "";
    //     exit;
    // }

    // ดึงข้อมูลแพ็คเกจของผู้ใช้งาน
    $sql = "SELECT p.PolicyName, p.imageName, cp.PaymentStatus, cp.EnrollmentDate ,cp.PolicyID
        FROM customerpolicy cp
        JOIN policy p ON cp.PolicyID = p.PolicyID
        WHERE cp.CustomerID = ?";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("SQL Error: " . $conn->error);
    }
    $stmt->bind_param("i", $userID);  // ใช้ $userID แทน $customerID
    $stmt->execute();
    $result = $stmt->get_result();
    $packages = $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : [];

    ?>

    <script>
        console.log("Mode: <?php echo $_SESSION['mode']; ?>");
        console.log("Username: <?php echo $_SESSION['username']; ?>");
        console.log("User ID: <?php echo $_SESSION['userID']; ?>");
    </script>
    <!-- ---------------------------------------------------------- NavBar Section ---------------------------------------------------------- -->

    <nav>
        <div class="nav-container">
            <div class="left">
                <a href="index.php" class="logo"><img class="NOSlogo" src="images/NOSlogo.png" alt=""></a>
                <ul class="nav-links">
                    <li><a href="index.php">HOME</a></li>
                    <li><a href="">CONTENT</a></li>
                    <li><a href="CS-package.php">PACKAGES</a></li>
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

    <!-- ------------------------------------------------------ Profile Section ---------------------------------------------------------- -->

    <div class="spacer">
        <!-- <div class="normalspace" id="message-container"> -->
    </div>
    <div class="Tittleofpage">
        <h1>MY PROFILE</h1>
    </div>

    <div class="mainsection">
        <div class="leftside">
            <div class="Userprofile_piccontainer ">
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

                    <div class="imgcontainer fade-up" style="position: relative;">
                        <img src="<?php echo $profilePicturePath; ?>" alt="User Profile Picture" class="profilepicture">
                        <?php if (isset($_SESSION['mode']) && $_SESSION['mode'] === 'edit'): ?>
                            <!-- <p class="editprofilepicbt" id="changeProfileBtn">Change Profile</p> -->
                        <?php endif; ?>
                    </div>

                    <!-- Modal for Upload -->
                    <div id="uploadModal" class="modal" style="display: none;">
                        <div class="modal-content">
                            <span class="close" id="closeModal">&times;</span>
                            <h2>Upload Profile Picture</h2>
                            <form id="uploadForm" enctype="multipart/form-data">
                                <input type="file" name="Image" id="uploadModal" accept="image/png, image/jpeg" required>
                                <button type="submit" class="uploadButton" id="closeModal">Change Profile</button>
                            </form>
                        </div>
                    </div>



                <?php else: ?>
                    <p>error cant load user info</p>
                <?php endif; ?>
            </div>
            <div class="profiletool fade-up">
                <?php
                if (isset($_SESSION['mode']) && $_SESSION['mode'] === 'view') {
                    echo '
            <div class="toolrow" id="edit-button">
                <img src="images/edit.png" alt="" class="toolicon">
                <p>EDIT</p>
            </div>

            <div class="toolrow">
                <img src="images/notification.png" alt="" class="toolicon">
                <p>NOTIFICATION</p>
            </div>

            <div class="toolrow">
                <img src="images/logout.png" alt="" class="toolicon">
                <a href="logout.php" style="text-decoration:none; color:black;">
                    <p>LOG OUT</p>
                </a>
            </div>

            <div class="toolrow">
                <img src="images/information.png" alt="" class="toolicon">
                <p>HELP</p>
            </div>
        ';
                } elseif (isset($_SESSION['mode']) && $_SESSION['mode'] === 'edit') {
                    echo '
            <div class="toolrow" id="confirm-button">
                <img src="images/confirm.png" alt="" class="toolicon">
                <p>CONFIRM</p>
            </div>

            <div class="toolrow" id="cancel-button">
                <img src="images/canclepng" alt="" class="toolicon">
                <p>CANCEL</p>
            </div>
        ';
                }
                ?>
            </div>


        </div>
        <div class="rightside fade-up">
            <div class="selfinfosection">
                <div class="sectiontittle">
                    <h2>ข้อมูลส่วนตัว</h2>
                    <hr>
                </div>
                <div class="selfinfo">
                    <div class="personalform">
                        <div class="Lpersonalform">
                            <div>
                                <label for="firstname">ชื่อ:</label>
                                <input type="text" id="firstname" name="firstname" placeholder="Enter your first name" required>
                            </div>
                            <div>
                                <label for="gender">เพศ:</label>
                                <select id="gender" name="gender" required>
                                    <option value="">เลือกเพศ</option>
                                    <option value="male">ชาย</option>
                                    <option value="female">หญิง</option>
                                    <option value="other">อื่น ๆ</option>
                                </select>
                            </div>
                            <div>
                                <label for="address">ที่อยู่:</label>
                                <input type="text" id="address" name="address" placeholder="Enter your address" required>
                            </div>
                        </div>

                        <div class="Rpersonalform">
                            <div>
                                <label for="lastname">นามสกุล:</label>
                                <input type="text" id="lastname" name="lastname" placeholder="Enter your last name" required>
                            </div>

                            <div>
                                <div class="etandnation">
                                    <label for="ethnicity">เชื้อชาติ:</label>
                                    <input type="text" id="ethnicity" name="ethnicity" placeholder="Enter your ethnicity" required>
                                </div>

                                <div class="etandnation">
                                    <label for="nationality">สัญชาติ:</label>
                                    <input type="text" id="nationality" name="nationality" placeholder="Enter your nationality" required>
                                </div>
                            </div>
                            <div>
                                <div class="districtandprovince">
                                    <label for="district">อำเภอ:</label>
                                    <input type="text" id="district" name="district" placeholder="Enter your district" required>
                                </div>

                                <div class="districtandprovince">
                                    <label for="province">จังหวัด:</label>
                                    <input type="text" id="province" name="province" placeholder="Enter your province" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="personalcon">
                        <div>
                            <label for="postcode">รหัสไปรษณีย์:</label>
                            <input type="number" id="postcode" name="postcode" placeholder="Enter your postcode" required>
                        </div>
                        <div>
                            <label for="nationid">หมายเลขบัตรประชาชน:</label>
                            <input type="text" id="nationid" name="nationID" data-requirement="nationID" placeholder="Enter your National ID" required>
                        </div>
                        <div>
                            <label for="dateofbirth">วัน/เดือน/ปี ค.ศ. เกิด:</label>
                            <input type="date" id="dateofbirth" name="dateOfBirth" required>
                        </div>
                        <div>
                            <label for="tel">เบอร์โทรศัพท์มือถือ:</label>
                            <input type="tel" id="tel" name="phoneNumber" placeholder="Enter your phone number" required>
                        </div>
                        <div>
                            <label for="email">อีเมล์:</label>
                            <input type="email" id="email" name="email" placeholder="Enter your email address" data-requirement="email" required>
                        </div>
                        <div>
                            <label for="password">รหัสผ่าน:</label>
                            <input type="password" id="password" name="password" placeholder="Enter new password if changing">
                        </div>
                        <!-- <input type="hidden" id="customerID" name="customerID"> Hidden field for customer ID -->
                    </div>
                </div>

            </div>

            <div class="workinfosection">
                <div class="sectiontittle">
                    <h2>ข้อมูลส่วนตัว</h2>
                    <hr>
                </div>
                <div class="workinfo">
                    <div>
                        <div style="margin-right: 30px;">
                            <label for="occupation"
                                style=" justify-self: start;
                                                    width: 20%;
                                                    font-size: 17px;
                                                    font-weight: 500;
                                                    color: #333;
                                                    margin-bottom: 0px;">
                                อาชีพ:
                            </label>
                            <input type="text" id="occupation" name="occupation"
                                style=" justify-self: end;
                                                    width: 80%;
                                                    padding: 6px 10px;
                                                    font-size: 17px;
                                                    border: 1px solid #606060;" required>
                        </div>

                        <div>
                            <label for="salary"
                                style=" justify-self: start;
                                                    width: 20%;
                                                    font-size: 17px;
                                                    font-weight: 500;
                                                    color: #333;
                                                    margin-bottom: 0px;">
                                เงินเดือน:
                            </label>

                            <input type="number" id="salary" name="salary"
                                style=" justify-self: end;
                                                    width: 80%;
                                                    padding: 6px 10px;
                                                    font-size: 17px;
                                                    border: 1px solid #606060;" required>
                        </div>
                    </div>

                    <div style="width: 50%;">
                        <label for="workplace">สถานที่ทำงาน:</label>
                        <input type="text" id="workplace" name="workplace" required>
                    </div>
                </div>
            </div>

            <div class="healthsection">
                <div class="sectiontittle">
                    <h2>ประวัติสุขภาพ</h2>
                    <hr>
                </div>

                <div class="healthinfo">
                    <div>
                        <label for="healthhistory">ประวัติสุขภาพ:</label>
                        <input type="text" id="healthhistory" name="healthhistory" required>
                    </div>

                    <div>
                        <label for="medicalhistory">ประวัติการรักษา:</label>
                        <input type="text" id="medicalhistory" name="medicalhistory" required>
                    </div>

                    <div style="column-gap: 0px;">
                        <div>
                            <label for="weight">น้ำหนัก:</label>
                            <input type="number" id="weight" name="weight" style="margin-right: 20px;" required>
                            <label for="height">ส่วนสูง:</label>
                            <input type="number" id="height" name="height" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="packagesection">
                <div class="sectiontittle">
                    <h2>กรมธรรณ์</h2>
                    <hr>
                </div>
                <div class="packageinfo">
                    <?php if (!empty($packages)): ?>
                        <?php foreach ($packages as $package): ?>
                            <!-- <?php var_dump($package); ?> -->
                                <div class="card">
                                <img src="uploads/<?php echo htmlspecialchars($package['imageName']); ?>" alt="Package Image">
                                <a href="userprofile-package.php?id=<?php echo htmlspecialchars($package['PolicyID']); ?>">
                                <div class="content">
                                        <h3><?php echo htmlspecialchars($package['PolicyName']); ?></h3>
                                        <p class="payment-status <?php echo strtolower($package['PaymentStatus']); ?>">
                                            <?php echo $package['PaymentStatus'] === 'Paid' ? 'Payment Completed' : 'Pending Payment'; ?>
                                        </p>
                                        <p><strong>Enrollment Date:</strong> <?php echo htmlspecialchars($package['EnrollmentDate']); ?></p>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No packages found.</p>
                    <?php endif; ?>
                </div>
            </div>

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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const profileTool = document.querySelector('.profiletool');
            const profileForm = document.querySelector('.selfinfo');
            const workinfoForm = document.querySelector('.workinfo');
            const healthinfoForm = document.querySelector('.healthinfo');

            let currentMode = 'view'; // Initialize mode on the client side

            // Store initial data to revert on cancel
            let initialData = {};

            const collectFormData = () => {
                const data = {};
                document.querySelectorAll('input, select').forEach(input => {
                    data[input.name] = input.value;
                });
                return data;
            };

            const populateFields = (data) => {
                document.querySelectorAll('input, select').forEach(input => {
                    if (data[input.name]) {
                        input.value = data[input.name];
                    }
                });
            };

            const updateProfileButton = () => {
                fetch('render_profile_button.php') // Fetch the HTML for the "Change Profile" button
                    .then(response => response.text()) // Parse the response as text (HTML)
                    .then(html => {
                        const container = document.querySelector('.imgcontainer'); // Target the container
                        const buttonPlaceholder = container.querySelector('.editprofilepicbt'); // Look for the existing button

                        if (buttonPlaceholder) {
                            // Replace the existing button
                            buttonPlaceholder.outerHTML = html;
                        } else {
                            // Insert the button above the image if not present
                            container.insertAdjacentHTML('afterbegin', html);
                        }
                    })
                    .catch(error => console.error('Error updating profile button:', error));
            };

            const updateUploadForm = () => {
                fetch('render_upload_form.php') // Fetch the HTML for the form
                    .then(response => response.text()) // Parse the response as text (HTML)
                    .then(html => {
                        const container = document.querySelector('.imgcontainer'); // Target the container
                        const formPlaceholder = container.querySelector('#uploadForm'); // Look for the existing form

                        if (formPlaceholder) {
                            // Replace the existing form
                            formPlaceholder.outerHTML = html;
                        } else {
                            // Insert the form above the image if not present
                            container.insertAdjacentHTML('beforeend', html);
                        }

                        // Rebind the upload functionality
                        bindUploadForm();
                    })
                    .catch(error => console.error('Error updating upload form:', error));
            };

            // Bind the form functionality
            const bindUploadForm = () => {
                const uploadForm = document.getElementById('uploadForm');
                const username = '<?php echo $_SESSION['username']; ?>';

                if (uploadForm) {
                    uploadForm.addEventListener('submit', async (e) => {
                        e.preventDefault(); // Prevent the default form submission

                        const formData = new FormData(uploadForm);

                        try {
                            const response = await fetch('upload_profile_picture.php', {
                                method: 'POST',
                                body: formData,
                            });

                            const result = await response.json();

                            if (result.success) {
                                alert(result.message); // Show success message
                                document.querySelector('.profilepicture').src = `userprofiles/${username}.png?timestamp=${new Date().getTime()}`;
                            } else {
                                alert('Error: ' + result.error); // Show error message
                            }
                        } catch (error) {
                            console.error('Error uploading profile picture:', error);
                            alert('An unexpected error occurred. Please try again.');
                        }
                    });
                }
            };


            const toggleMode = (mode) => {
                currentMode = mode; // Update local mode
                console.log('currentMode:', currentMode);

                fetch('update_mode.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `mode=${mode}`, // Send the mode as POST data
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log(`Session mode updated to: ${data.mode}`);
                            // updateProfileButton(); // Show the "Change Profile" button
                            updateUploadForm();
                        } else {
                            console.error('Failed to update session mode:', data.error);
                        }
                    })
                    .catch(error => console.error('Error updating session mode:', error));

                console.log(`Switching to ${mode} mode`);



                if (mode === 'edit') {
                    initialData = collectFormData();

                    profileTool.innerHTML = `
                <div class="toolrow" id="confirm-button">
                    <img src="images/confirm.png" alt="" class="toolicon">
                    <p>CONFIRM</p>
                </div>
                <div class="toolrow" id="cancel-button">
                    <img src="images/cancel.png" alt="" class="toolicon">
                    <p>CANCEL</p>
                </div>
            `;

                    profileForm.querySelectorAll('input, select').forEach(input => {
                        input.removeAttribute('readonly');
                        input.removeAttribute('disabled');
                    });
                    workinfoForm.querySelectorAll('input').forEach(input => {
                        input.removeAttribute('readonly');
                        input.removeAttribute('disabled');
                    });
                    healthinfoForm.querySelectorAll('input').forEach(input => {
                        input.removeAttribute('readonly');
                        input.removeAttribute('disabled');
                    });

                    document.getElementById('confirm-button').addEventListener('click', async () => {
                        const updatedData = collectFormData();
                        console.log('Confirming changes:', updatedData);


                        try {
                            const response = await fetch('updatedata.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify(updatedData),
                            });

                            const result = await response.json();
                            if (result.success) {
                                showMessage('Profile updated successfully!', 'success');
                                toggleMode('view');
                                // updateProfileSection(); // Update the profile section dynamically
                            } else {
                                showMessage('Error: ' + result.error, 'error');
                            }
                        } catch (error) {
                            console.error('Update failed:', error);
                            showMessage('An error occurred while updating your profile.', 'error');
                        }
                    });

                    document.getElementById('cancel-button').addEventListener('click', () => {
                        console.log('Cancelling changes');
                        populateFields(initialData);
                        toggleMode('view');
                        // updateProfileSection(); // Update the profile section dynamically
                    });
                } else if (mode === 'view') {
                    profileTool.innerHTML = `
                <div class="toolrow" id="edit-button">
                    <img src="images/edit.png" alt="" class="toolicon">
                    <p>EDIT</p>
                </div>
                <div class="toolrow">
                    <img src="images/notification.png" alt="" class="toolicon">
                    <p>NOTIFICATION</p>
                </div>
                <div class="toolrow">
                    <img src="images/logout.png" alt="" class="toolicon">
                    <a href="logout.php" style="text-decoration:none; color:black;">
                        <p>LOG OUT</p>
                    </a>
                </div>
                <div class="toolrow">
                    <img src="images/information.png" alt="" class="toolicon">
                    <p>HELP</p>
                </div>
            `;

                    profileForm.querySelectorAll('input, select').forEach(input => {
                        input.setAttribute('readonly', true);
                        input.setAttribute('disabled', true);
                    });
                    workinfoForm.querySelectorAll('input').forEach(input => {
                        input.setAttribute('readonly', true);
                        input.setAttribute('disabled', true);
                    });
                    healthinfoForm.querySelectorAll('input').forEach(input => {
                        input.setAttribute('readonly', true);
                        input.setAttribute('disabled', true);
                    });

                    document.getElementById('edit-button').addEventListener('click', () => {
                        toggleMode('edit');
                        // $_SESSION['mode'] = 'editmode';
                    });
                }
            };

            // Initialize in view mode
            toggleMode('view');


        });




        // -------------------------------------- Fetch Data from Loaddata.php --------------------------------------
        document.addEventListener('DOMContentLoaded', () => {
            const profileForm = document.querySelector('.selfinfo');
            const workinfoForm = document.querySelector('.workinfo');
            const healthinfoForm = document.querySelector('.healthinfo');

            // Fetch data from loaddata.php
            fetch('loaddata.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log("Data fetched successfully:", data.data);

                        // Populate the fields
                        populateFields(profileForm, data.data);
                        populateFields(workinfoForm, data.data);
                        populateFields(healthinfoForm, data.data);
                    } else {
                        console.error("Error fetching data:", data.error);
                        showMessage("Failed to load user data. Please try again.", 'error');
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    showMessage("An unexpected error occurred while loading data.", 'error');
                });

            // Function to populate form fields
            function populateFields(form, data) {
                form.querySelectorAll('input, select').forEach(input => {
                    const name = input.name; // The "name" attribute of the field
                    if (data[name]) {
                        input.value = data[name]; // Populate the field with corresponding data
                    }
                });
            }
        });

        // Function to display messages in the spacer
        function showMessage(message, type) {
            console.log("Showing message:", message, type);

            // Get the message container element
            const messageContainer = document.getElementById('message-container');

            // Check if the messageContainer exists
            if (messageContainer) {
                // Update the message content
                messageContainer.innerHTML = `<p class="alert alert-${type}">${message}</p>`;

                smoothScrollTo(0, 1000);
                // Smooth scroll to the top of the page
                // window.scrollTo({
                //     top: 0,
                //     behavior: 'smooth'
                // });
            } else {
                console.error("Message container not found.");
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const uploadForm = document.getElementById('uploadForm');

            if (uploadForm) {
                uploadForm.addEventListener('submit', async (e) => {
                    e.preventDefault(); // Prevent the default form submission

                    const formData = new FormData(uploadForm);

                    try {
                        const response = await fetch('upload_profile_picture.php', {
                            method: 'POST',
                            body: formData,
                        });

                        const result = await response.json();

                        if (result.success) {
                            alert(result.message); // Show success message
                            location.reload(); // Reload the page to show the updated profile picture
                        } else {
                            alert('Error: ' + result.error); // Show error message
                        }
                    } catch (error) {
                        console.error('Error uploading profile picture:', error);
                        alert('An unexpected error occurred. Please try again.');
                    }
                });
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            // const changeProfileBtn = document.getElementById('changeProfileBtn');
            // const uploadModal = document.getElementById('uploadModal');
            // const closeModal = document.getElementById('closeModal');

            // // Show the modal when the "Change Profile" button is clicked
            // changeProfileBtn.addEventListener('click', () => {
            //     console.log('Opening upload modal');
            //     uploadModal.style.display = 'block'; // Show the modal
            // });

            // // Close the modal when the "X" button is clicked
            // closeModal.addEventListener('click', () => {
            //     uploadModal.style.display = 'none'; // Hide the modal
            // });

            // // Close the modal when clicking outside of the modal content
            // window.addEventListener('click', (event) => {
            //     if (event.target === uploadModal) {
            //         uploadModal.style.display = 'none'; // Hide the modal
            //     }
            // });

            // Handle the form submission via AJAX
            const uploadForm = document.getElementById('uploadForm');

            if (uploadForm) {
                uploadForm.addEventListener('submit', async (e) => {
                    e.preventDefault(); // Prevent default form submission

                    const formData = new FormData(uploadForm);

                    try {
                        const response = await fetch('upload_profile_picture.php', {
                            method: 'POST',
                            body: formData,
                        });

                        const result = await response.json();

                        if (result.success) {
                            alert(result.message); // Show success message
                            document.querySelector('.profilepicture').src = `userprofiles/${username}.png?timestamp=${new Date().getTime()}`;
                            uploadModal.style.display = 'none'; // Close the modal after successful upload
                        } else {
                            alert('Error: ' + result.error); // Show error message
                        }
                    } catch (error) {
                        console.error('Error uploading profile picture:', error);
                        alert('An unexpected error occurred. Please try again.');
                    }
                });
            }
        });
    </script>

    <script src="js/smoothscroll.js"></script>
    <script src="js/scrollFade.js"></script>


</body>

</html>