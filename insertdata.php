<?php
header('Content-Type: application/json'); // Ensure the response is JSON
try {
    require 'db_connection.php';
    require_once 'switfmailer/vendor/autoload.php'; // SwiftMailer autoload

    // Enable error reporting for debugging
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Log debug information to a file instead of echoing it
    file_put_contents('php_debug.log', "Request Method: " . $_SERVER['REQUEST_METHOD'] . PHP_EOL, FILE_APPEND);
    file_put_contents('php_debug.log', "Input: " . file_get_contents('php://input') . PHP_EOL, FILE_APPEND);

    // Ensure only POST requests are handled
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405); // Method Not Allowed
        echo json_encode(['success' => false, 'error' => 'Invalid request method']);
        exit();
    }

    // Parse JSON input
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data) {
        http_response_code(400); // Bad Request
        echo json_encode(['success' => false, 'error' => 'Invalid input']);
        exit();
    }

    // Retrieve data from JSON payload
    $userID = uniqid('user_', true);
    $nationID = $data['nationid'] ?? null;
    $dateOfBirth = $data['dateofbirth'] ?? null;
    $postcode = $data['postcode'] ?? null;
    $phoneNumber = $data['tel'] ?? null;
    $email = $data['email'] ?? null;
    $password = password_hash($data['password'] ?? '', PASSWORD_DEFAULT);
    $firstName = $data['firstname'] ?? null;
    $lastName = $data['lastname'] ?? null;
    $gender = $data['sex'] ?? null;
    $address = $data['address'] ?? null;
    $ethnicity = $data['ethnicity'] ?? null;
    $nationality = $data['nationality'] ?? null;
    $district = $data['district'] ?? null;
    $province = $data['province'] ?? null;
    $occupation = $data['occupation'] ?? null;
    $salary = $data['salary'] ?? 0;
    $workplace = $data['workplace'] ?? null;
    $healthHistory = $data['healthhistory'] ?? null;
    $medicalHistory = $data['medicalhistory'] ?? null;
    $weight = $data['weight'] ?? 0;
    $height = $data['height'] ?? 0;

    // Validate required fields
    $requiredFields = [
        'nationID' => $nationID,
        'dateOfBirth' => $dateOfBirth,
        'postcode' => $postcode,
        'phoneNumber' => $phoneNumber,
        'email' => $email,
        'password' => $password,
        'firstName' => $firstName,
        'lastName' => $lastName,
        'gender' => $gender,
        'address' => $address,
    ];

    foreach ($requiredFields as $field => $value) {
        if (empty($value)) {
            http_response_code(400); // Bad Request
            echo json_encode(['success' => false, 'error' => "Missing required field: $field"]);
            exit();
        }
    }

    // Database operations
    $conn->begin_transaction(); // Start transaction

    try {
        // Insert into `users` table
        $stmt1 = $conn->prepare("INSERT INTO users (userID, name, userRole) VALUES (?, ?, ?)");
        $fullName = $firstName . ' ' . $lastName;
        $userRole = 'Customer';
        $stmt1->bind_param("sss", $userID, $fullName, $userRole);
        $stmt1->execute();

        // Insert into `customer` table
        $stmt2 = $conn->prepare("
            INSERT INTO customer (
                customerID, nationID, dob, postalcode, phonenumber, email, 
                firstname, lastname, gender, address, ethnicity, nationality, 
                district, province, occupation, salary, workplace, healthhistory, 
                medicalhistory, weight, height
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt2->bind_param(
            "sssssssssssssssssssdd",
            $userID,
            $nationID,
            $dateOfBirth,
            $postcode,
            $phoneNumber,
            $email,
            $firstName,
            $lastName,
            $gender,
            $address,
            $ethnicity,
            $nationality,
            $district,
            $province,
            $occupation,
            $salary,
            $workplace,
            $healthHistory,
            $medicalHistory,
            $weight,
            $height
        );
        $stmt2->execute();

        // Insert into `logincredentials` table
        $stmt3 = $conn->prepare("INSERT INTO logincredentials (userID, email, passwordhash, verification_token, status) VALUES (?, ?, ?, ?, ?)");
        $status = 'Waiting for verify';
        $verification_token = bin2hex(random_bytes(16)); // Generate unique token
        $stmt3->bind_param("sssss", $userID, $email, $password, $verification_token, $status);
        $stmt3->execute();

        $conn->commit(); // Commit transaction

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
        $verification_link = "http://localhost/NOS_Webapplication/verify_email.php?token=" . urlencode($verification_token);
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

            $mailer->send($message); // Send the message
        

        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        $conn->rollback(); // Rollback transaction
        http_response_code(500); // Internal Server Error
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    } finally {
        if (isset($stmt1)) $stmt1->close();
        if (isset($stmt2)) $stmt2->close();
        if (isset($stmt3)) $stmt3->close();
        $conn->close();
    }
} catch (Exception $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
