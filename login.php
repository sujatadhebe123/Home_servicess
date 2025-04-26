<?php
$servername = "localhost";
$username = "root";  // Change if needed
$password = "";      // Change if needed
$dbname = "home_maintenance";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user data
    $sql = "SELECT * FROM users1 WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;

            // Insert login record into the logins table
            $login_sql = "INSERT INTO logins (username, login_time) VALUES ('$username', NOW())";
            $conn->query($login_sql);

            // Redirect to dashboard after successful login
            header("Location: dashboard.html");
            exit();
        } else {
            echo "<script>alert('Invalid password!'); window.location='login.html';</script>";
        }
    } else {
        echo "<script>alert('User  not found! Please register.'); window.location='register.html';</script>";
    }
}

$conn->close();
?>