<?php
require 'db_connection.php';
session_start();

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid User ID.");
}

$userID = $_GET['id'];

// Check user role
$checkRoleQuery = "SELECT Userrole FROM users WHERE userID = ?";
$stmt = $conn->prepare($checkRoleQuery);
$stmt->bind_param("s", $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    die("User role not found.");
}

$userRole = $result->fetch_assoc()['Userrole']; // Fetch role

// Initialize variables
$userData = [];
$policyData = [];

// Fetch user details and policies
if ($userRole === 'Customer') {
    // Fetch customer data
    $query = "SELECT 
                c.CustomerID, 
                CONCAT(c.FirstName, ' ', c.LastName) AS FullName, 
                c.nationID, c.dob,c.gender,c.weight,c.height,c.ethnicity,c.nationality, c.address,c.district,c.province,c.postalcode, c.PhoneNumber, c.occupation, c.workplace,c.salary,
                lc.email, lc.status , c.healthhistory,c.medicalhistory
              FROM customer c
              INNER JOIN logincredentials lc ON c.CustomerID = lc.userID
              WHERE c.CustomerID = ?";

    // Fetch customer policies
    $policyQuery = "SELECT 
                        cp.PolicyID, 
                        p.PolicyName, 
                        p.PolicyType, 
                        p.CoverageAmount, 
                        p.Premium, 
                        cp.Paymentstatus, 
                        cp.EnrollmentDate
                   FROM customerpolicy cp
                   INNER JOIN policy p ON cp.PolicyID = p.PolicyID
                   WHERE cp.CustomerID = ?";
} elseif ($userRole === 'Employee') {
    // Fetch employee data
    $query = "SELECT 

                e.EmployeeID AS CustomerID, 
                CONCAT(e.FirstName, ' ', e.LastName) AS FullName, 
                e.nationID, e.dob,e.gender,e.weight,e.height,e.ethnicity,e.nationality, e.address,e.district,e.province,e.postalcode, e.PhoneNumber, e.occupation, e.workplace,e.salary,
                le.email, le.status , e.healthhistory,e.medicalhistory
              FROM employees e
              INNER JOIN logincredentials le ON e.EmployeeID = le.userID
              WHERE e.EmployeeID = ?";

    // Fetch employee policies
    $policyQuery = "SELECT 
                        ep.PolicyID, 
                        p.PolicyName, 
                        p.PolicyType, 
                        p.CoverageAmount, 
                        p.Premium, 
                        ep.Paymentstatus, 
                        ep.EnrollmentDate
                   FROM employeepolicy ep
                   INNER JOIN policy p ON ep.PolicyID = p.PolicyID
                   WHERE ep.EmployeeID = ?";
} else {
    die("Invalid user role.");
}

// Fetch user details
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $userData = $result->fetch_assoc();
} else {
    die("User data not found.");
}

// Fetch policy details
$stmt = $conn->prepare($policyQuery);
$stmt->bind_param("s", $userID);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $policyData[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>User Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px auto;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        h1, h2 {
            text-align: center;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body >
    <h1><?php echo htmlspecialchars($userRole); ?> Details</h1>
    <table>
        <tr>
            <th>User ID</th>
            <td><?php echo htmlspecialchars($userData['CustomerID']); ?></td>
        </tr>
        <tr>
            <th>Full Name</th>
            <td><?php echo htmlspecialchars($userData['FullName']); ?></td>
        </tr>
        <tr>
            <th>National ID</th>
            <td><?php echo htmlspecialchars($userData['nationID']); ?></td>
        </tr>
        <tr>
            <th>Date of Birth</th>
            <td><?php echo htmlspecialchars($userData['dob']); ?></td>
        </tr>
        
        <tr>
            <th>Gender</th>
            <td><?php echo htmlspecialchars($userData['gender']); ?></td>
        </tr>

        <tr>
            <th>Weight</th>
            <td><?php echo htmlspecialchars($userData['weight']); ?></td>
        </tr>

        <tr>
            <th>Height</th>
            <td><?php echo htmlspecialchars($userData['height']); ?></td>
        </tr>

        <tr>
            <th>Ethnicity</th>
            <td><?php echo htmlspecialchars($userData['ethnicity']); ?></td>
        </tr>

        <tr>
            <th>Nationality</th>
            <td><?php echo htmlspecialchars($userData['nationality']); ?></td>
        <tr>
            <th>Address</th>
            <td><?php echo htmlspecialchars($userData['address']); ?></td>
        </tr>

        <tr>
            <th>District</th>
            <td><?php echo htmlspecialchars($userData['district']); ?></td>
        </tr>

        <tr>
            <th>Province</th>
            <td><?php echo htmlspecialchars($userData['province']); ?></td>
        </tr>

        <tr>
            <th>Postal Code</th>
            <td><?php echo htmlspecialchars($userData['postalcode']); ?></td>
        </tr>

        <tr>
            <th>Phone Number</th>
            <td><?php echo htmlspecialchars($userData['PhoneNumber']); ?></td>
        </tr>

        <tr>
            <th>Occupation</th>
            <td><?php echo htmlspecialchars($userData['occupation']); ?></td>
        </tr>

        <tr>
            <th>Workplace</th>
            <td><?php echo htmlspecialchars($userData['workplace']); ?></td>
        </tr>

        <tr>
            <th>Salary</th>
            <td><?php echo htmlspecialchars($userData['salary']); ?></td>
        </tr>

        <tr>
            <th>Health History</th>
            <td><?php echo htmlspecialchars($userData['healthhistory']); ?></td>
        </tr>

        <tr>
            <th>Medical History</th>
            <td><?php echo htmlspecialchars($userData['medicalhistory']); ?></td>
        </tr>
        

        <tr>
            <th>Email</th>
            <td><?php echo htmlspecialchars($userData['email']); ?></td>
        </tr>
        <tr>
            <th>Status</th>
            <td><?php echo htmlspecialchars($userData['status']); ?></td>
        </tr>


    </table>

    <!-- Policy Section -->
    <h2>Associated Policies</h2>
    <?php if (!empty($policyData)): ?>
        <table>
            <thead>
                <tr>
                    <th>Policy ID</th>
                    <th>Policy Name</th>
                    <th>Policy Type</th>
                    <th>Coverage Amount</th>
                    <th>Premium</th>
                    <th>Payment Status</th>
                    <th>Enrollment Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($policyData as $policy): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($policy['PolicyID']); ?></td>
                        <td><?php echo htmlspecialchars($policy['PolicyName']); ?></td>
                        <td><?php echo htmlspecialchars($policy['PolicyType']); ?></td>
                        <td><?php echo htmlspecialchars(number_format($policy['CoverageAmount'], 2)); ?></td>
                        <td><?php echo htmlspecialchars(number_format($policy['Premium'], 2)); ?></td>
                        <td><?php echo htmlspecialchars($policy['Paymentstatus']); ?></td>
                        <td><?php echo htmlspecialchars($policy['EnrollmentDate']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align: center;">No policies found for this user.</p>
    <?php endif; ?>

    <a href="userdashboardforadmin.php">Back to Dashboard</a>
</body>

</html>
