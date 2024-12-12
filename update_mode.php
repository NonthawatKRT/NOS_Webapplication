<?php
session_start();

if (isset($_POST['mode'])) {
    $mode = $_POST['mode']; // Get the mode from the AJAX request
    $_SESSION['mode'] = $mode; // Set the session mode
    echo json_encode(['success' => true, 'mode' => $_SESSION['mode']]); // Return the updated mode
} else {
    echo json_encode(['success' => false, 'error' => 'Mode not provided']);
}
?>
