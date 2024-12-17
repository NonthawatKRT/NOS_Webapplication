<?php
require 'db_connection.php';
require_once 'switfmailer/vendor/autoload.php'; // SwiftMailer autoload
session_start();

try {
    // Check for valid parameters
    if (!isset($_GET['id'], $_GET['UserID']) || !is_numeric($_GET['id'])) {
        throw new Exception("Invalid parameters.");
    }

    $policyID = htmlspecialchars($_GET['id']);
    $userID = htmlspecialchars($_GET['UserID']);

    // Step 1: Update Payment Status
    $updatePaymentSQL = "UPDATE customerpolicy SET PaymentStatus = 'Paid' WHERE CustomerID = ? AND PolicyID = ?";
    $stmt = $conn->prepare($updatePaymentSQL);
    if (!$stmt) {
        throw new Exception("SQL Error: " . $conn->error);
    }
    $stmt->bind_param("ii", $userID, $policyID);

    if (!$stmt->execute()) {
        throw new Exception("Failed to update payment status.");
    }

    // Step 2: Fetch All SalesIDs and Pick Random One
    $salesIDs = [];
    $querySales = "SELECT SalesID FROM sales";
    $result = $conn->query($querySales);
    if (!$result) {
        throw new Exception("SQL Error: " . $conn->error);
    }

    while ($row = $result->fetch_assoc()) {
        $salesIDs[] = $row['SalesID'];
    }

    if (count($salesIDs) === 0) {
        throw new Exception("No sales representatives found.");
    }
    $randomSalesID = $salesIDs[array_rand($salesIDs)];

    // Step 3: Fetch EmployeeID
    $queryEmployee = "SELECT EmployeeID FROM sales WHERE SalesID = ?";
    $stmt = $conn->prepare($queryEmployee);
    $stmt->bind_param("s", $randomSalesID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        throw new Exception("No employee found for the selected SalesID.");
    }
    $employee = $result->fetch_assoc();
    $randomSalesEmpID = $employee['EmployeeID'];

    //get user role
    $queryUserRole = "SELECT UserRole FROM users WHERE UserID = ?";
    $stmt = $conn->prepare($queryUserRole);
    $stmt->bind_param("s", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        throw new Exception("No user found for the selected UserID.");
    }
    $user = $result->fetch_assoc();

    if ($user['UserRole'] == 'Customer') {
        // Step 4: Insert into salescustomer Table
        $salesCustomerID = uniqid('salescustomer_', true);
        $insertSalesCustomer = "INSERT INTO salescustomer (SalesCustomerID, SalesID, CustomerID,PolicyID) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insertSalesCustomer);
        $stmt->bind_param("sssi", $salesCustomerID, $randomSalesID, $userID, $policyID);

        if (!$stmt->execute()) {
            throw new Exception("Error inserting into salescustomer: " . $stmt->error);
        }

        // Step 5: Fetch Sale and Customer Info
        $querySaleInfo = "SELECT lc.email, e.firstname, e.lastname 
                  FROM logincredentials lc 
                  INNER JOIN employees e ON lc.userID = e.EmployeeID 
                  WHERE lc.userID = ?";
        $stmt = $conn->prepare($querySaleInfo);
        $stmt->bind_param("s", $randomSalesEmpID);
        $stmt->execute();
        $saleInfo = $stmt->get_result()->fetch_assoc();

        $queryCustomerInfo = "SELECT lc.email, c.firstname, c.lastname, c.phonenumber 
                      FROM logincredentials lc 
                      INNER JOIN customer c ON lc.userID = c.CustomerID 
                      WHERE lc.userID = ?";
        $stmt = $conn->prepare($queryCustomerInfo);
        $stmt->bind_param("s", $userID);
        $stmt->execute();
        $customerInfo = $stmt->get_result()->fetch_assoc();

        $queryPackageInfo = "SELECT PolicyName, PolicyType, CoverageAmount, Premium, TermLength, Description FROM policy WHERE PolicyID = ?";
        $stmt = $conn->prepare($queryPackageInfo);
        $stmt->bind_param("i", $policyID);
        $stmt->execute();
        $packageInfo = $stmt->get_result()->fetch_assoc();

        // Step 6: Send Email with SwiftMailer
        $transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
            ->setUsername('NonthawatForStudy@gmail.com')
            ->setPassword('ifre wgkn uknu ecox')
            ->setStreamOptions([
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ],
            ]);

        $mailer = new Swift_Mailer($transport);

        $subject = "New Customer Registration - {$packageInfo['PolicyName']}";
        $bodyContent = "
        <html>
        <head><style>
            .email-container { font-family: Arial, sans-serif; max-width: 600px; margin: auto; background: #f9f9f9; border: 1px solid #ddd; border-radius: 8px; padding: 20px; }
            .header { background: #7f878f; color: #fff; padding: 10px; text-align: center; }
            .content p { font-size: 14px; line-height: 1.6; color: #333; }
            .footer { font-size: 12px; color: #777; text-align: center; margin-top: 20px; }
        </style></head>
        <body>
            <div class='email-container'>
                <div class='header'><h2>New Customer Package Assignment</h2></div>
                <div class='content'>
                    <p>Hello <strong>{$saleInfo['firstname']} {$saleInfo['lastname']}</strong>,</p>
                    <p>A new customer <strong>{$customerInfo['firstname']} {$customerInfo['lastname']}</strong> has registered for the <strong>{$packageInfo['PolicyName']}</strong> package.</p>
                    <p><strong>Customer Contact:</strong> {$customerInfo['phonenumber']} | {$customerInfo['email']}</p>
                    <p><strong>Package Details:</strong><br>
                    Policy Type: {$packageInfo['PolicyType']}<br>
                    Coverage: {$packageInfo['CoverageAmount']}<br>
                    Premium: {$packageInfo['Premium']}<br>
                    Term: {$packageInfo['TermLength']}<br>
                    Description: {$packageInfo['Description']}</p>
                </div>
                <div class='footer'>Nonthawat For Study Team &copy; 2024</div>
            </div>
        </body>
        </html>";

        $message = (new Swift_Message($subject))
            ->setFrom(['NonthawatForStudy@gmail.com' => 'Nonthawat For Study'])
            ->setTo([$saleInfo['email'] => "{$saleInfo['firstname']} {$saleInfo['lastname']}"])
            ->setBody($bodyContent, 'text/html');

        if ($mailer->send($message)) {
            echo "Payment updated, sales representative notified.";
        } else {
            throw new Exception("Failed to send the notification email.");
        }
    } else {
        echo "Payment updated.";
        $updatePaymentSQL = "UPDATE employeepolicy SET PaymentStatus = 'Paid' WHERE EmployeeID = ? AND PolicyID = ?";
        $stmt = $conn->prepare($updatePaymentSQL);
        if (!$stmt) {
            throw new Exception("SQL Error: " . $conn->error);
        }
        $stmt->bind_param("si", $userID, $policyID);

        if (!$stmt->execute()) {
            throw new Exception("Failed to update payment status.");
        }

    }
    echo "<script>alert('Payment confirmed!'); window.location.href = 'userprofile.php';</script>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} finally {
    $conn->close();
}
