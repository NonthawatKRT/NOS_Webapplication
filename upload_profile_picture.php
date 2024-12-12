<?php
session_start();

// Check if user is logged in and session variables exist
if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'error' => 'User not logged in']);
    exit();
}

// Check if a file has been uploaded
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['Image'])) {
    // Define the upload directory
    $uploadDir = 'userprofiles/';

    // Ensure the directory exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Create the directory if it doesn't exist
    }

    // Get the uploaded file's temporary path
    $imageTmpPath = $_FILES['Image']['tmp_name'];

    // Use the username as the file name (or email if required)
    $imageName = $_SESSION['username'] . ".png";

    // Full path to store the image
    $imagePath = $uploadDir . $imageName;

    // Validate the uploaded file type
    $allowedTypes = ['image/png', 'image/jpeg'];
    if (!in_array($_FILES['Image']['type'], $allowedTypes)) {
        echo json_encode(['success' => false, 'error' => 'Invalid file type. Only PNG and JPEG are allowed.']);
        exit();
    }

    // Validate the file size (e.g., max 2MB)
    if ($_FILES['Image']['size'] > 2 * 1024 * 1024) { // 2 MB limit
        echo json_encode(['success' => false, 'error' => 'File size exceeds 2 MB']);
        exit();
    }

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
    echo json_encode(['success' => false, 'error' => 'Invalid request or no file uploaded']);
}
?>
