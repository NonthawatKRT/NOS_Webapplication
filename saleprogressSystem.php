

<?php
session_start();

// Initialize the progress in session if it’s not already set
if (!isset($_SESSION['progress'])) {
    $_SESSION['progress'] = 1; // Start at step 1
}

function resetProgress() {
    echo "Reset progress function called<br>";
    // Reset session progress
    $_SESSION['progress'] = 1;

    // Clear other session data if needed
    unset($_SESSION['nationid'], $_SESSION['dob'], $_SESSION['postcode'], $_SESSION['tel'], $_SESSION['email']);
    unset($_SESSION['firstname'], $_SESSION['lastname'], $_SESSION['sex'], $_SESSION['address']);
    unset($_SESSION['ethnicity'], $_SESSION['nationality'], $_SESSION['district'], $_SESSION['province']);
    unset($_SESSION['occupation'], $_SESSION['salary'], $_SESSION['workplace']);
    unset($_SESSION['healthhistory'], $_SESSION['medicalhistory'], $_SESSION['weight'], $_SESSION['height']);
}

// Debugging incoming request
error_log("POST data: " . print_r($_POST, true));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        echo "Action received: " . htmlspecialchars($_POST['action']) . "<br>";

        if ($_POST['action'] === 'reset') {
            echo "Reset action detected<br>";
            resetProgress(); // Call the resetProgress function to clear session data
            echo json_encode(['status' => 'success']); // Send a success response
            exit();
        }

        if ($_POST['action'] === 'back') {
            echo "Back action detected<br>";
            if ($_SESSION['progress'] > 1) {
                $_SESSION['progress']--; // Move back one step
                echo "Progress moved back to: " . $_SESSION['progress'] . "<br>";
            }
            header("Location: saleregister.php"); // Redirect back to the same page
            exit();
        }

        if ($_POST['action'] === 'next') {
            echo "Next action detected<br>";
            if ($_SESSION['progress'] < 4) { // Assuming the last step is 4
                $_SESSION['progress']++; //5Move forward one step
                echo "Progress moved forward to: " . $_SESSION['progress'] . "<br>";
            }
            header("Location: saleregister.php");
            exit();
        }
        if ($_POST['action'] === 'confirm') {
            echo "confirm step<br>";
            if ($_SESSION['progress'] == 4) { // Assuming the last step is 5
                $_SESSION['progress']++; //5Move forward one step
                echo "Progress moved forward to: " . $_SESSION['progress'] . "<br>";
            }
            header("Location: saleregister.php");
            exit();
        }
    }

    // Redirect back to register.php after processing
    echo "No valid action detected. Redirecting to register.php<br>";
    header("Location: saleregister.php");
    exit();
}

// Display current progress for debugging (optional)
// echo "Current progress: " . $_SESSION['progress'] . "<br>";
