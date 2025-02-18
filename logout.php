<?php
session_start();
if (isset($_POST['logout'])) {
    session_destroy();
    echo "<script>
        localStorage.setItem('logoutMessage', 'You have been logged out successfully.');
        window.location.href = 'login.php';
    </script>";
    exit();
}
?>
