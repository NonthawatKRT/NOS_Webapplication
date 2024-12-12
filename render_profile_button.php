<?php
session_start();

if (isset($_SESSION['mode']) && $_SESSION['mode'] === 'edit') {
    echo '<p class="editprofilepicbt">Change Profile</p>';
} else {
    echo ''; // No button for view mode
}
?>
