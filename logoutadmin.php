<?php
session_start();
session_destroy(); // Destroy all session data
header("Location: admin_login.html"); // Redirect to login page
exit();
?>
