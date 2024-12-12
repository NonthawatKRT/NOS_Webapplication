<!-- ------------------------------------------------- Register Page ---------------------------------------------------
file use:
    required: db_connection.php
    required: progressSystem.php
    required: insertdata.php
    required: check_duplicate.php
    required: register.css
    required: Navbar.css
    required: Footer.css
    required: smoothscroll.js
    required: scrollfade.js
-------------------------------------------------------------------------------------------------------------------- -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel="stylesheet" href="css/Navbar.css">
    <link rel="stylesheet" href="css/Footer.css">
    <link rel="stylesheet" href="css/register.css">
</head>

<body>

    <?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Connect to the database
    require 'db_connection.php';
    require 'progressSystem.php';

    // Ensure session is started correctly
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }



    //----------------------------------------- Set Up Progress When Load -------------------------------------------------------

    // Check the current progress
    $progress = isset($_SESSION['progress']) ? $_SESSION['progress'] : 1;

    ?>


    <!-- ------------------------------------------- NavBar Section -------------------------------------------------------- -->

    <nav>
        <div class="nav-container">
            <div class="left">
                <a href="index.php" class="logo"><img class="NOSlogo" src="images/NOSlogo.png" alt=""></a>
                <ul class="nav-links">
                    <li><a href="index.php" id="current_page">HOME</a></li>
                    <li><a href="">CONTENT</a></li>
                    <li><a href="package.php">PACKAGES</a></li>
                    <P style=" margin-top: 0px; margin-bottom: 0px; margin-right: 20px;"> | </P>
                    <li><a href="">ABOUT US</a></li>
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

    <!-- ------------------------------------------------------ register Section ------------------------------------------ -->

    <div class="registersection">

        <div class="welcometext">
            <p>Welcome To NOS Insurance</p>
        </div>

        <section class="tittlesection">
            <div>
                <p>สมัครใช้บริการออนไลน์</p>
                <hr>
            </div>
        </section>

        <section class="mainsection">
            <div class="progressbar">
                <div class="circleprogress" style="margin-top: 15px;">
                    <div class="circleicon <?php echo ($progress == 1) ? 'active' : (($progress > 1) ? 'done' : ''); ?>">
                        <?php if ($progress <= 1): ?>
                            <p>1</p>
                        <?php else: ?>
                            <img src="images/checkmarkicon.png" alt="Checkmark" class="checkmarkicon">
                        <?php endif; ?>
                    </div>
                    <p class="progresslebel">ข้อกำหนด<br>เเละเงื่อนไขบริการ</p>
                </div>
                <div class="arrowicon">
                    <img src="images/long_arrow.png" alt="">
                </div>

                <div class="circleprogress">
                    <div class="circleicon <?php echo ($progress == 2) ? 'active' : (($progress > 2) ? 'done' : ''); ?>">
                        <?php if ($progress <= 2): ?>
                            <p>2</p>
                        <?php elseif ($progress > 2): ?>
                            <img src="images/checkmarkicon.png" alt="Checkmark" class="checkmarkicon">
                        <?php endif; ?>
                    </div>
                    <p class="progresslebel">ระบุข้อมูลบัญชี</p>
                </div>
                <div class="arrowicon">
                    <img src="images/long_arrow.png" alt="">
                </div>

                <div class="circleprogress">
                    <div class="circleicon <?php echo ($progress == 3) ? 'active' : (($progress > 3) ? 'done' : ''); ?>">
                        <?php if ($progress <= 3): ?>
                            <p>3</p>
                        <?php elseif ($progress > 3): ?>
                            <img src="images/checkmarkicon.png" alt="Checkmark" class="checkmarkicon">
                        <?php endif; ?>
                    </div>
                    <p class="progresslebel">กำหนดข้อมูลผู้ใช้งาน</p>
                </div>
                <div class="arrowicon">
                    <img src="images/long_arrow.png" alt="">
                </div>

                <div class="circleprogress" style="margin-top: 15px" ;>
                    <div class="circleicon <?php echo ($progress == 4) ? 'active' : (($progress > 4) ? 'done' : ''); ?>">
                        <?php if ($progress <= 4): ?>
                            <p>4</p>
                        <?php elseif ($progress > 4): ?>
                            <img src="images/checkmarkicon.png" alt="Checkmark" class="checkmarkicon">
                        <?php endif; ?>
                    </div>
                    <p class="progresslebel">ตรวจสอบ<br>เเละยืนยันข้อมูล</p>
                </div>

            </div>

            <div class="maincontentsection">
                <?php if ($progress == 1): ?>
                    <div class="termsection">
                        <div class="sectionlebel">
                            <h2>ข้อกำหนดและเงื่อนไขบริการ</h2>
                        </div>
                        <div class="scrollableterm">
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptates tempore molestiae animi
                                consequuntur ex libero quia ipsum voluptas voluptatum temporibus voluptatem, quibusdam possimus
                                eos. Delectus, iste? Perspiciatis atque quod modi illum assumenda nostrum voluptatum voluptatem
                                est dolorum expedita consectetur animi fugiat excepturi quisquam, nam itaque, similique cumque
                                magnam sit ea distinctio aspernatur corporis. Adipisci provident, cupiditate labore id, totam in
                                cumque officia sapiente eum sunt esse ducimus repudiandae, illum accusamus aut quo. Ducimus animi
                                laboriosam nostrum modi. Rerum expedita consectetur magni iure corporis, eveniet autem facere
                                nobis officia? Quos dicta odit debitis cupiditate est architecto corporis modi aspernatur
                                voluptates suscipit totam, recusandae neque sint distinctio unde doloremque quia quasi.
                                Odio nisi similique sunt sed eius aut sit, nesciunt, dolore nemo, laudantium ab error a nam?
                                Iste, eveniet cupiditate nam neque harum quisquam sequi magnam aliquid fuga molestiae assumenda
                                in necessitatibus molestias, unde delectus? Obcaecati rerum quis veritatis aliquam accusantium?
                                Error ipsa aspernatur temporibus provident vel totam non nisi et sapiente aliquam. Nam nihil
                                ipsam beatae temporibus totam soluta molestias explicabo dolorem tempore voluptas, libero ullam
                                officia esse. Amet voluptates quia sequi quasi, impedit nisi assumenda eaque nihil cum deserunt ab
                                facere maxime vel architecto iusto, ducimus ea inventore ipsa cumque laudantium corporis
                                aspernatur veritatis debitis deleniti. Adipisci odit quaerat temporibus aliquid, in, vitae
                                necessitatibus inventore incidunt sequi est doloribus, exercitationem perferendis illo sint
                                facilis deleniti excepturi. Autem doloremque deserunt fuga quo? Voluptatem iusto vel aliquam
                                quaerat commodi, tempora neque dolor ab. Est asperiores quos quia cum distinctio impedit, quo,
                                illum neque voluptas quasi sequi laboriosam culpa alias molestiae. Laborum officiis ut tempore,
                                sit expedita maxime accusamus officia doloremque aliquid, suscipit perferendis temporibus labore
                                unde veniam rerum dolorum, aliquam earum delectus placeat. Eius corrupti explicabo eveniet
                                asperiores ipsam necessitatibus, optio nihil! Ullam et hic officia modi pariatur! Dolorum animi
                                obcaecati facere, deserunt suscipit nesciunt saepe minus laboriosam, est voluptatibus tempora
                                eius nihil harum ipsum ex! Incidunt vel, quasi dolor officiis ducimus iusto fugit earum laborum
                                llam quis nisi? Odio culpa, molestias soluta officia suscipit necessitatibus! Repellendus ad
                                iure mollitia quam reiciendis ducimus illo quibusdam soluta totam aliquam facilis, doloribus
                                laboriosam porro odit voluptas perferendis et est ullam non perspiciatis eaque, asperiores
                                voluptates quos. Ad cupiditate, dolor repudiandae mollitia repellendus obcaecati unde nam
                                temporibus esse culpa facere corrupti eaque deserunt ipsam, est, maiores ipsa tempore beatae
                                animi? Soluta debitis laborum cupiditate quas quisquam ipsam eaque, consectetur a adipisci
                                amet. Illo, ullam quis! Adipisci sunt nam inventore quia culpa, ad unde tempora laborum aut
                                animi quis nobis quidem autem maiores ea quaerat beatae commodi, non voluptatibus tempore
                                laudantium. Expedita impedit maxime magni. Sed illo et inventore temporibus at velit tempore
                                est tenetur dolore quibusdam nisi eos cumque numquam reprehenderit amet, repellat voluptas
                                omnis! Quia illo at amet tempore? Sit sapiente, odit laboriosam ratione facere alias
                                molestias ducimus animi nemo tempore minima consequatur, amet nisi quaerat et. Quaerat
                                non quasi rem quam recusandae? Esse odit magni distinctio fugiat repellendus aliquam
                                perspiciatis deleniti corporis, ullam sunt optio, cupiditate autem voluptates veniam
                                sequi exercitationem dolorum temporibus!
                            </p>
                        </div>

                        <form class="buttoncontainer" action="register.php" method="POST">
                            <!-- <input type="hidden" name="action" value="next"> -->
                            <button type="submit" name="action" value="next" class="confirmbt">ยอมรับ</button>
                            <button type="submit" name="cancel" class="canclebt">ยกเลิก</button>
                        </form>


                    </div>
                <?php endif; ?>

                <?php if ($progress == 2): ?>
                    <div class="accountsection">
                        <div class="sectionlebel">
                            <h2>กรุณากรอกข้อมูล</h2>
                            <p>ข้อมูลบัญชี</p>
                            <hr>
                        </div>
                        <div id="error-messages"></div>
                        <div class="formsection">
                            <form action="register.php" id="registration-form" method="post">
                                <div class="acountform">
                                    <div>
                                        <label for="nationid">หมายเลขบัตรประชาชน</label>
                                        <input type="text" id="nationid" name="nationid" data-requirement="nationid" required>
                                    </div>

                                    <div>
                                        <label for="dateofbirth">วัน/เดือน/ปี ค.ศ. เกิด</label>
                                        <input type="date" id="dateofbirth" name="dateofbirth" required>
                                    </div>

                                    <div>
                                        <label for="postcode">รหัสไปรษณีย์</label>
                                        <input type="number" id="postcode" name="postcode" required>
                                    </div>

                                    <div>
                                        <label for="tel">เบอร์โทรศัพท์มือถือ</label>
                                        <input type="tel" id="tel" name="tel" required>
                                    </div>

                                    <div>
                                        <label for="email">อีเมล์</label>
                                        <input type="email" id="email" name="email" data-requirement="email" required>
                                    </div>

                                    <div>
                                        <label for="password">รหัสผ่าน</label>
                                        <input type="password" id="password" name="password" data-requirement="password" required>
                                    </div>

                                    <div>
                                        <label for="confirmPassword">ยืนยันรหัสผ่าน</label>
                                        <input type="password" id="confirmPassword" name="confirmPassword" data-requirement="confirmPassword" required>
                                    </div>
                                </div>
                                <div class="buttoncontainer">
                                    <form action="register.php" method="POST">
                                        <input type="hidden" name="action" value="next">
                                        <button type="submit" id="submit-button" name="action" value="next" class="confirmbt" disabled>ต่อไป</button>
                                    </form>
                                    <!-- <div class="buttoncontainer">
                                    <button type="submit" name="action" value="next" class="confirmbt">ยืนยัน</button>
                                </div> -->
                            </form>

                            <!-- Separate Back Button -->
                            <form action="register.php" method="POST" class="back-form">
                                <input type="hidden" name="action" value="back">
                                <button type="submit" class="backbt">ย้อนกลับ</button>
                            </form>

                        </div>

                    <?php endif; ?>

                    <?php if ($progress == 3): ?>
                        <div class="selfinfo">
                            <form action="register.php" method="post">
                                <div class="selfinfo">
                                    <div class="sectionlebel">
                                        <h2>กรุณากรอกข้อมูล</h2>
                                        <p>ข้อมูลส่วนตัว</p>
                                        <hr>
                                    </div>
                                    <!-- <form action="register.php" method="post"> -->
                                    <div class="personalform">
                                        <div class="Lpersonalform">
                                            <div>
                                                <label for="firstname">ชื่อ: </label>
                                                <input type="text" id="firstname" name="firstname" required>
                                            </div>
                                            <div>
                                                <label for="sex">เพศ:</label>
                                                <select id="sex" name="sex" required>
                                                    <!-- Default option -->
                                                    <option value="">เลือกเพศ</option>

                                                    <!-- Male option -->
                                                    <option value="male">ชาย</option>

                                                    <!-- Female option -->
                                                    <option value="female">หญิง</option>

                                                    <!-- Other option -->
                                                    <option value="other">อื่น ๆ</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label for="address">ที่อยู่:</label>
                                                <input type="text" id="address" name="address" required>
                                            </div>
                                        </div>

                                        <div class="Rpersonalform">
                                            <div>
                                                <label for="lastname">นามสกุล: </label>
                                                <input type="text" id="lastname" name="lastname" required>
                                            </div>

                                            <div>
                                                <div class="etandnation">
                                                    <label for="ethnicity">เชื้อชาติ:</label>
                                                    <input type="text" id="ethnicity" name="ethnicity" required>
                                                </div>

                                                <div class="etandnation">
                                                    <label for="nationality">สัญชาติ:</label>
                                                    <input type="text" id="nationality" name="nationality" required>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="districtandprovince">
                                                    <label for="district">อำเภอ:</label>
                                                    <input type="text" id="district" name="district" required>
                                                </div>

                                                <div class="districtandprovince">
                                                    <label for="province">จังหวัด:</label>
                                                    <input type="text" id="province" name="province" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- </form> -->

                                    <div class="sectionlebel">
                                        <p>ข้อมูลการทำงาน</p>
                                        <hr>
                                    </div>

                                    <div class="workinfo">
                                        <div>
                                            <div style="margin-right: 30px;">
                                                <label for="occupation">อาชีพ:</label>
                                                <input type="text" id="occupation" name="occupation" required>
                                            </div>

                                            <div>
                                                <label for="salary"
                                                    style=" justify-self: start;
                                                    width: 15%;
                                                    font-size: 17px;
                                                    font-weight: 500;
                                                    color: #333;
                                                    margin-bottom: 0px;">
                                                    เงินเดือน:
                                                </label>

                                                <input type="number" id="salary" name="salary"
                                                    style=" justify-self: end;
                                                    width: 85%;
                                                    padding: 6px 10px;
                                                    font-size: 17px;
                                                    border: 1px solid #606060;" required>
                                            </div>
                                        </div>

                                        <div>
                                            <label for="workplace">สถานที่ทำงาน:</label>
                                            <input type="text" id="workplace" name="workplace" required>
                                            <div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="sectionlebel">
                                        <p>ประวัติสุขภาพ</p>
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
                                <div class="buttoncontainer">
                                    <form action="register.php" method="POST">
                                        <input type="hidden" name="action" value="next">
                                        <button type="submit" name="action" value="next" class="confirmbt">ต่อไป</button>
                                    </form>
                                    <!-- <div class="buttoncontainer">
                                    <button type="submit" name="action" value="next" class="confirmbt">ยืนยัน</button>
                                </div> -->
                            </form>
                            <!-- Separate Back Button -->
                            <form action="register.php" method="POST" class="back-form">
                                <input type="hidden" name="action" value="back">
                                <button type="submit" class="backbt">ย้อนกลับ</button>
                            </form>

                        </div>

                    </div>

                <?php endif; ?>

                <?php if ($progress == 4): ?>
                    <div class="confirmsection">
                        <div class="sectionlebel">
                            <h2>ตรวจสอบข้อมูล</h2>
                            <p>กรุณาตรวจสอบข้อมูลบัญชี</p>
                            <hr>
                        </div>
                        <div id="reviewData">
                            <!-- User-entered data will be displayed here -->
                        </div>
                        <div class="buttoncontainer">
                            <form action="register.php" method="post">
                                <div class="buttoncontainer">
                                    <button type="submit" name="action" value="confirm" class="lastconfirmbt" id="confirm-btn">ยืนยัน</button>
                                </div>
                            </form>

                            <form action="register.php" method="POST" class="back-form">
                                <input type="hidden" name="action" value="back">
                                <button type="submit" class="backbt">แก้ไข</button>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($progress == 5): ?>
                    <div class="completesection">
                        <div class="buttoncontainer">
                            <form action="register.php" method="post">

                                <div class="mainconfirmsection fade-up">
                                    <img src="images/Confirmmark.png" alt="Checkmark" class="confirmmarkicon">
                                    <h2>สมัครสมาชิกเรียบร้อย</h2>
                                    <p>กรุณาตรวจสอบอีเมล์ของท่านเพื่อยืนยันตัวตน</p>
                                </div>

                                <div class="buttoncontainer fade-up">
                                    <button type="submit" name="action" value="exit" class="exitbt">ยืนยัน</button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- -------------------------------------------- JavaScript ------------------------------------------------------------------ -->

            <script>

                // ----------------------------------------Correct Data Requirement ---------------------------------------------------

             // Assign the PHP session variable to a JavaScript variable
            const progress = <?php echo json_encode($_SESSION['progress'] ?? 0); ?>;
            if (progress >= 2 ) {
                

                document.addEventListener('DOMContentLoaded', () => {
                    const form = document.getElementById('registration-form');
                    const inputs = form.querySelectorAll('input[data-requirement]');
                    const submitButton = document.getElementById('submit-button');
                    const errorMessages = document.getElementById('error-messages');

                    // Validation rules
                    const validators = {
                        nationid: async (value) => {
                            if (value.length !== 13) return "National ID must be 13 characters long.";

                            // Check if nationID exists in the database
                            const response = await fetch('check_duplicate.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded'
                                },
                                body: new URLSearchParams({
                                    nationid: value
                                }).toString()
                            });
                            const result = await response.json();
                            if (!result.success) return result.error;

                            return null; // No errors
                        },

                        email: async (value) => {
                            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                            if (!emailRegex.test(value)) return "Invalid email format.";

                            // Check if email exists in the database
                            const response = await fetch('check_duplicate.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded'
                                },
                                body: new URLSearchParams({
                                    email: value
                                }).toString()
                            });
                            const result = await response.json();
                            if (!result.success) return result.error;

                            return null; // No errors
                        },

                        password: (value) => {
                            const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*\-^]).{8,}$/;
                            if (!passwordRegex.test(value)) {
                                return "Password must include at least 1 uppercase, 1 lowercase, 1 number, and 1 special character (!@#$%^&*-^).";
                            }
                            return null; // No errors
                        },

                        confirmPassword: (value) => {
                            const password = document.getElementById('password').value;
                            if (value.trim() === '') return "Please confirm your password.";
                            if (value !== password) return "Passwords do not match.";

                            return null; // No errors
                        }

                    };

                    //------------------------------- Highlight Error Input Field ---------------------------------------------

                    // Validate a single input
                    const validateInput = async (input) => {
                        const requirement = input.dataset.requirement;
                        const value = input.value;
                        const error = validators[requirement] ? await validators[requirement](value) : null;

                        if (error) {
                            input.style.borderColor = 'red';
                            input.style.borderWidth = '2px';
                            input.dataset.error = error;
                        } else {
                            input.style.borderColor = 'green';
                            input.style.borderWidth = '2px';
                            delete input.dataset.error;
                        }
                    };

                    //----------------------------- Display Error Messages Dynamically ------------------------------------------

                    // Display error messages dynamically
                    const displayErrors = () => {
                        const errors = Array.from(inputs)
                            .filter(input => input.dataset.error)
                            .map(input => input.dataset.error);

                        if (errors.length > 0) {
                            errorMessages.innerHTML = `<ul>${errors.map(error => `<li>${error}</li>`).join('')}</ul>`;
                            errorMessages.style.display = 'block';
                        } else {
                            errorMessages.style.display = 'none';
                            errorMessages.innerHTML = '';
                        }
                    };

                    // Enable or disable the submit button based on errors
                    const updateSubmitButtonState = () => {
                        const hasErrors = Array.from(inputs).some(input => input.dataset.error);
                        submitButton.disabled = hasErrors;
                    };

                    
                    /* ----------------------------------------------------------------------------------------------------

                                                *** Store Input Values in Session Storage System***
                    
                    ------------------------------------------------------------------------------------------------------*/

                    // Validate all inputs on page load
                    const validateAllInputsOnLoad = async () => {
                        for (const input of inputs) {
                            const value = sessionStorage.getItem(input.name) || input.value;
                            input.value = value; // Set value from session storage if available
                            await validateInput(input);
                        }
                        displayErrors();
                        updateSubmitButtonState();
                    };

                    // Add event listeners for input changes
                    inputs.forEach(input => {
                        input.addEventListener('input', async () => {
                            sessionStorage.setItem(input.name, input.value); // Save input value to sessionStorage
                            await validateInput(input);
                            displayErrors();
                            updateSubmitButtonState();
                        });
                    });

                    // Validate all inputs on page load
                    validateAllInputsOnLoad();

                    //-----------------------------------------------------------------------------------------------------


                    //------------------------------- Submit Button State Update ------------------------------------------

                    // Handle form submission
                    form.addEventListener('submit', (event) => {
                        event.preventDefault(); // Prevent default submission

                        // Final validation check
                        displayErrors();
                        updateSubmitButtonState();

                        if (!submitButton.disabled) {
                            form.submit(); // Submit the form if valid
                        }
                    });
                });


            } 
                //------------------------------------------------------------------------------------------------------


                /* ----------------------------------------------------------------------------------------------------

                                                *** Store Input Values in Session Storage System***
                    
                ------------------------------------------------------------------------------------------------------*/

                document.addEventListener('DOMContentLoaded', () => {
                    const form = document.querySelector('form');
                    const inputs = document.querySelectorAll('.acountform input, .personalform input, .personalform select, .workinfo input, .healthinfo input, .usersection input');

                    // Load saved values from sessionStorage
                    inputs.forEach(input => {
                        const savedValue = sessionStorage.getItem(input.name);
                        if (savedValue) {
                            input.value = savedValue;
                            console.log('Loaded saved ', input.name, ' : ', savedValue);
                        }
                    });

                    // Save input values to sessionStorage on input
                    inputs.forEach(input => {
                        input.addEventListener('input', () => {
                            sessionStorage.setItem(input.name, input.value);
                            console.log('Saved input ', input.name, ' : ', input.value);
                        });
                    });

                    //----------------------------------------------------------------------------------------------


                    //------------------------------------- Prevent Change Page -------------------------------------

                    let isFormSubmitted = false; // Track form submission

                    // Detect if the user is navigating away from the `register.php` page
                    function isLeavingRegisterPage(event) {
                        const currentPage = location.pathname; // Current page URL path
                        const nextPage = event.target.activeElement?.href || ''; // Next navigation target
                        return nextPage && !nextPage.includes('register.php'); // Check if the next page is not `register.php`
                    }

                    // Prevent navigating away without confirmation
                    function handleBeforeUnload(event) {
                        if (!isFormSubmitted) {
                            const leavingRegister = isLeavingRegisterPage(event);

                            if (leavingRegister) {
                                const confirmLeave = confirm("Are you sure you want to leave this page? Your progress will be lost.");

                                if (confirmLeave) {
                                    console.log("User confirmed leave. Clearing session storage...");
                                    sessionStorage.clear();

                                    // Attempt synchronous fetch to reset progress
                                    const xhr = new XMLHttpRequest();
                                    xhr.open("POST", "progressSystem.php", false); // `false` makes it synchronous
                                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                    xhr.send("action=reset");
                                    console.log("Server progress reset synchronously.");

                                    resetProgressOnServer(); // Also call asynchronous function for safety
                                } else {
                                    console.log("User chose to stay on the page.");
                                    sessionStorage.clear(); // Clear session storage

                                    resetProgressOnServer(); // Reset progress on the server

                                    event.preventDefault();

                                    event.returnValue = ""; // Necessary for some browsers
                                }
                            }
                        }
                    }

                    // ----------------------------------- Reset Progress on Server -------------------------------------

                    //                         **** Reset Progress And Clear Session Storage ****

                    // --------------------------------------------------------------------------------------------------


                    // Send a reset request to the server
                    async function resetProgressOnServer() {
                        try {
                            const response = await fetch('progressSystem.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded',
                                },
                                body: new URLSearchParams({
                                    action: 'reset'
                                }).toString(),
                            });

                            if (response.ok) {
                                console.log("Server progress reset successfully.");
                            } else {
                                console.error("Failed to reset server progress.");
                            }
                        } catch (error) {
                            console.error("Error during server reset:", error);
                        }
                    }


                    // Attach `beforeunload` event listener
                    window.addEventListener('beforeunload', (event) => {
                        handleBeforeUnload(event);
                    });

                    // Handle form submission to remove the warning
                    form.addEventListener('submit', () => {
                        isFormSubmitted = true;
                        window.removeEventListener('beforeunload', handleBeforeUnload);
                    });


                    // ---------------------------- Cancle Button to trigger resetprogress --------------------

                    const cancelBtn = document.querySelector('.canclebt');
                    if (cancelBtn) {
                        cancelBtn.addEventListener('click', (event) => {
                            event.preventDefault(); // Prevent default form submission

                            // Clear sessionStorage
                            sessionStorage.clear();

                            // Reset session on the server and then redirect
                            fetch('progressSystem.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded',
                                    },
                                    body: new URLSearchParams({
                                        action: 'reset', // Assuming the server-side script resets the session
                                    }).toString(),
                                })
                                .then((response) => {
                                    if (!response.ok) {
                                        console.error('Failed to reset progress on the server.');
                                    }
                                    // Redirect to login page after resetting the session
                                    window.location.href = 'login.php';
                                })
                                .catch((error) => {
                                    console.error('Error sending reset request:', error);
                                    // Redirect to login page even if there's an error
                                    window.location.href = 'login.php';
                                });
                        });
                    }

                    // ---------------------------------------------------------------------------------------------

                    //                      **** Confirm Button Trigger Submit Data ****

                    //                     **** Send Data Payload To insertData.php ****                            
                    
                    //     **** Disable Submit Button And Back Button To Prevent Spamming  While Email Sending****

                    // ---------------------------------------------------------------------------------------------

                    const lastconfirmbt = document.querySelector('.lastconfirmbt');
                    const backbt = document.querySelector('.backbt');
                    if (lastconfirmbt) {
                        lastconfirmbt.addEventListener('click', (event) => {
                            console.log('Confirm button clicked');

                            // Disable the button to prevent spamming
                            lastconfirmbt.disabled = true;
                            backbt.disabled = true;

                            // Optionally show a loading indicator
                            document.body.innerHTML += '<div class="loading-indicator">Processing...</div>';

                            // Collect data from session storage
                            const data = {
                                nationid: sessionStorage.getItem('nationid'),
                                dateofbirth: sessionStorage.getItem('dateofbirth'),
                                postcode: sessionStorage.getItem('postcode'),
                                tel: sessionStorage.getItem('tel'),
                                email: sessionStorage.getItem('email'),
                                password: sessionStorage.getItem('password'),
                                firstname: sessionStorage.getItem('firstname'),
                                lastname: sessionStorage.getItem('lastname'),
                                sex: sessionStorage.getItem('sex'),
                                address: sessionStorage.getItem('address'),
                                ethnicity: sessionStorage.getItem('ethnicity'),
                                nationality: sessionStorage.getItem('nationality'),
                                district: sessionStorage.getItem('district'),
                                province: sessionStorage.getItem('province'),
                                occupation: sessionStorage.getItem('occupation'),
                                salary: sessionStorage.getItem('salary'),
                                workplace: sessionStorage.getItem('workplace'),
                                healthhistory: sessionStorage.getItem('healthhistory'),
                                medicalhistory: sessionStorage.getItem('medicalhistory'),
                                weight: sessionStorage.getItem('weight'),
                                height: sessionStorage.getItem('height'),
                            };

                            console.log('Data being sent to insertData.php:', data);

                            // Step 1: Insert data into the database
                            fetch('insertdata.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                    },
                                    body: JSON.stringify(data),
                                })
                                .then((response) => {
                                    console.log('Response from insertdata.php:', response);
                                    if (!response.ok) {
                                        throw new Error(`Failed to insert data. HTTP status: ${response.status}`);
                                    }
                                    return response.json();
                                })
                                .then((result) => {
                                    console.log('Result from insertdata.php:', result);
                                    if (result.success) {
                                        console.log('Data inserted successfully');
                                        // alert('Data inserted successfully. Please check your email to verify your account.');

                                        // Step 2: Send confirmation to progressSystem.php
                                        return fetch('progressSystem.php', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/x-www-form-urlencoded',
                                            },
                                            body: new URLSearchParams({
                                                action: 'confirm',
                                            }).toString(),
                                        });
                                    } else {
                                        throw new Error(result.error || 'Unknown error during data insertion');
                                    }
                                })
                                .then((response) => {
                                    console.log('Response from progressSystem.php:', response);
                                    if (!response.ok) {
                                        throw new Error(`Failed to confirm progress. HTTP status: ${response.status}`);
                                    }
                                    return response.text(); // Optional: debug response body
                                })
                                .then((progressResult) => {
                                    console.log('ProgressSystem.php response body:', progressResult);

                                    // Redirect to login page after all processes are successful
                                    window.location.href = 'register.php';
                                })
                                .catch((error) => {
                                    console.error('Error in processing:', error); // Log the specific error
                                    alert('An error occurred. Please try again later.');

                                    // Optionally re-enable the button if needed
                                    lastconfirmbt.disabled = false;
                                    backbt.disabled = false;
                                    document.querySelector('.loading-indicator').remove();
                                });
                        });
                    }

                    //--------------------------------- Exit Button To Reset Progress -----------------------------------

                    const ExitBtn = document.querySelector('.exitbt');
                    if (ExitBtn) {
                        ExitBtn.addEventListener('click', (event) => {
                            event.preventDefault(); // Prevent default form submission

                            // Clear sessionStorage
                            sessionStorage.clear();

                            // Reset session on the server and then redirect
                            fetch('progressSystem.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded',
                                    },
                                    body: new URLSearchParams({
                                        action: 'reset', // Assuming the server-side script resets the session
                                    }).toString(),
                                })
                                .then((response) => {
                                    if (!response.ok) {
                                        console.error('Failed to reset progress on the server.');
                                    }
                                    // Redirect to login page after resetting the session
                                    window.location.href = 'login.php';
                                })
                                .catch((error) => {
                                    console.error('Error sending reset request:', error);
                                    // Redirect to login page even if there's an error
                                    window.location.href = 'login.php';
                                });
                        });
                    }

                    
                    //-----------------------------------------------------------------------------------------------------

                    //                     **** Show Up Data At Last Step Of Registeration ****

                    //----------------------------------------------------------------------------------------------------

                    // Check if we are on progress 4
                    if (<?php echo json_encode($progress); ?> === 4) {
                        const reviewContainer = document.getElementById("reviewData");

                        // Define the fields to display (these should match your form field names)
                        const fields = {
                            nationid: "หมายเลขบัตรประชาชน",
                            dateofbirth: "วัน/เดือน/ปี ค.ศ. เกิด",
                            postcode: "รหัสไปรษณีย์",
                            tel: "เบอร์โทรศัพท์มือถือ",
                            email: "อีเมล์",
                            firstname: "ชื่อ",
                            lastname: "นามสกุล",
                            sex: "เพศ",
                            address: "ที่อยู่",
                            ethnicity: "เชื้อชาติ",
                            nationality: "สัญชาติ",
                            district: "อำเภอ",
                            province: "จังหวัด",
                            occupation: "อาชีพ",
                            salary: "เงินเดือน",
                            workplace: "สถานที่ทำงาน",
                            healthhistory: "ประวัติสุขภาพ",
                            medicalhistory: "ประวัติการรักษา",
                            weight: "น้ำหนัก",
                            height: "ส่วนสูง"
                        };

                        // Create a table for displaying the data
                        let tableHTML = "<table class='review-table'>";
                        for (const [key, label] of Object.entries(fields)) {
                            const value = sessionStorage.getItem(key) || "ไม่ระบุ";
                            tableHTML += `
                <tr>
                    <td>${label}</td>
                    <td>${value}</td>
                </tr>
            `;
                        }
                        tableHTML += "</table>";

                        // Insert the table into the review container
                        reviewContainer.innerHTML = tableHTML;
                    }
                });
            </script>
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
    <script src="js/scrollfade.js"></script>

</body>

</html>