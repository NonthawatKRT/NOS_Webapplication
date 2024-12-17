<?php
header('Content-Type: application/json');
require 'db_connection.php';
require_once 'switfmailer/vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Log debug info
file_put_contents('php_debug.log', "Request Method: " . $_SERVER['REQUEST_METHOD'] . PHP_EOL, FILE_APPEND);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid input']);
    exit();
}

// Assign and validate variables
$userID = uniqid('user_', true);
$dateOfBirth = $data['dateofbirth'] ?? null;
$phoneNumber = $data['tel'] ?? null;
$email = $data['email'] ?? null;
$password = password_hash($data['password'] ?? '', PASSWORD_DEFAULT);
$firstName = $data['firstname'] ?? null;
$lastName = $data['lastname'] ?? null;
$gender = $data['sex'] ?? null;
$nationID = $data['nationid'] ?? null;
$postcode = $data['postcode'] ?? null;
$address = $data['address'] ?? null;
$ethnicity = $data['ethnicity'] ?? null;
$nationality = $data['nationality'] ?? null;
$district = $data['district'] ?? null;
$province = $data['province'] ?? null;
$occupation = $data['occupation'] ?? null;
$salary = $data['salary'] ?? null;
$workplace = $data['workplace'] ?? null;
$healthHistory = $data['healthhistory'] ?? null;
$medicalHistory = $data['medicalhistory'] ?? null;
$weight = $data['weight'] ?? null;
$height = $data['height'] ?? null;

$conn->begin_transaction();

try {
    // Insert into `users`
    $stmt1 = $conn->prepare("INSERT INTO users (userID, name, userRole) VALUES (?, ?, ?)");
    $fullName = $firstName . ' ' . $lastName;
    $userRole = 'Employee';
    $stmt1->bind_param("sss", $userID, $fullName, $userRole);
    if (!$stmt1->execute()) {
        throw new Exception("Users insert failed: " . $stmt1->error);
    }

    // Insert into `employees`
    $stmt2 = $conn->prepare("
        INSERT INTO employees (
            EmployeeID, nationID, dob, postalcode, phonenumber, email, firstname,
            lastname, gender, address, ethnicity, nationality, district, province, 
            occupation, salary, workplace, healthhistory, medicalhistory, status, 
            weight, height
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $status = 'Active';
    $stmt2->bind_param(
        "ssssssssssssssssssssdd",
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
        $status,
        $weight,
        $height
    );
    if (!$stmt2->execute()) {
        throw new Exception("Employees insert failed: " . $stmt2->error);
    }

    // Insert into `logincredentials`
    $stmt3 = $conn->prepare("INSERT INTO logincredentials (userID, email, passwordhash, verification_token, status) VALUES (?, ?, ?, ?, ?)");
    $verification_token = bin2hex(random_bytes(16));
    $stmt3->bind_param("sssss", $userID, $email, $password, $verification_token, $status);
    if (!$stmt3->execute()) {
        throw new Exception("Login credentials insert failed: " . $stmt3->error);
    }

    $stmt4 = $conn->prepare("INSERT INTO sales (salesID, EmployeeID,role) VALUES (?, ?, ?)");
    $saleID = uniqid('sale_', true);
    $Role = 'SalesRep';
    $stmt4->bind_param("sss", $saleID, $userID, $Role);
    if (!$stmt4->execute()) {
        throw new Exception("Sales insert failed: " . $stmt4->error);
    }

    $conn->commit();

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
                                <h1>Welcome To NOS Insurance</h1>
                            </div>
                            <div class='content'>
                                <p>Hello <strong>$fullName</strong>,</p>
                                <p>Thank you for registering! Welcome to NOS Insurance.co Wish you happy to work with us.If you have any questions feel free to ask :)</p>
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
    $conn->rollback();
    error_log("Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
} finally {
    $stmt1->close();
    $stmt2->close();
    $stmt3->close();
    $stmt4->close();
    $conn->close();
}
