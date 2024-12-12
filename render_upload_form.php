<?php
session_start();

if (isset($_SESSION['mode']) && $_SESSION['mode'] === 'edit') {
    echo '
    <form id="uploadForm" enctype="multipart/form-data">
        <input type="file" name="Image" accept="image/png, image/jpeg" required>
        <button type="submit" class="uploadButton">Upload Picture</button>
    </form>
    ';
} else {
    echo ''; // No form for view mode
}
?>
