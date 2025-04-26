<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Hardcoded admin credentials
    $adminUsername = "admin";
    $adminPassword = "admin123";

    if ($username === $adminUsername && $password === $adminPassword) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: view_complaints.php");
        exit;
    } else {
        $error = "Invalid admin credentials.";
        header("Location: admin_login.html?error=" . urlencode($error));
        exit;
    }
}
?>
