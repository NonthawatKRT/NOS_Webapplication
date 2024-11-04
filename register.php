<?php
// Connect to the database
require 'db_connection.php';
require_once 'switfmailer/vendor/autoload.php'; // SwiftMailer autoload

// Enable error display for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prefix = $_POST['prefix'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $sex = $_POST['sex'];
    $dateofbirth = $_POST['dateofbirth'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $address = $_POST['address'];
    $nationID = $_POST['nationID'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Generate unique user ID and set status
    $user_id = uniqid('user_', true);
    $status = 'waiting for verify';
    $userrole = 'Guest';
    $verification_token = bin2hex(random_bytes(16)); // Generate a unique token
    $fullName = $firstname . ' ' . $lastname; // Concatenate first and last names

    // Insert into `users` table
    $sql = "INSERT INTO users (userID, name , userRole) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $user_id, $fullName, $userrole);
    if (!$stmt->execute()) {
        echo "<script>
            alert('Error inserting into users table: " . addslashes($stmt->error) . "');
            window.location.href = 'register.php';
        </script>";
        $stmt->close();
        $conn->close();
        exit();
    }
    $stmt->close();

    $sex = $prefix == "Male" ? "male" : "female";
    $CustomerID = $user_id;

    // Insert into `customer` table
    $sql = "INSERT INTO customer (CustomerID, firstname, lastname, gender, dob, nationID, email, phonenumber, address) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "<script>
            alert('Error preparing customer table statement: " . addslashes($conn->error) . "');
            window.location.href = 'register.php';
        </script>";
        exit();
    }
    $stmt->bind_param("sssssssss", $CustomerID, $firstname, $lastname, $sex, $dateofbirth, $nationID, $email, $tel, $address);
    if (!$stmt->execute()) {
        echo "<script>
            alert('Error inserting into customer table: " . addslashes($stmt->error) . "');
            window.location.href = 'register.php';
        </script>";
        $stmt->close();
        $conn->close();
        exit();
    }
    $stmt->close();

    // Insert into `logincredentials` table
    $sql = "INSERT INTO logincredentials (userID, email, passwordhash, verification_token, status) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "<script>
            alert('Error preparing logincredentials table statement: " . addslashes($conn->error) . "');
            window.location.href = 'register.php';
        </script>";
        exit();
    }

    $stmt->bind_param("sssss", $user_id, $email, $password, $verification_token, $status);
    if ($stmt->execute()) {
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
        $verification_link = "http://localhost/lifeinsurance_project/verify_email.php?token=" . urlencode($verification_token);
        $subject = "Email Verification";
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
                            <h1>Verify Your Email Address</h1>
                        </div>
                        <div class='content'>
                            <p>Hello <strong>$fullName</strong>,</p>
                            <p>Thank you for registering! Please confirm your email address by clicking the button below to complete your registration.</p>
                            <p><a href='$verification_link' class='btn'>Verify My Email</a></p>
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
            ->setTo([$email => $fullName])
            ->setBody($bodycontent, 'text/html');

        // Send the message
        if ($mailer->send($message)) {
            echo "<script>
                alert('Registration successful! Please check your email to verify your account.');
                window.location.href = 'login.php';
            </script>";
        } else {
            echo "<script>
                alert('Failed to send email.');
                window.location.href = 'register.php';
            </script>";
        }
    } else {
        echo "<script>
            alert('Error inserting into logincredentials table: " . addslashes($stmt->error) . "');
            window.location.href = 'register.php';
        </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
