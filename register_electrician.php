<?php
$servername = "localhost";
$username = "root"; // Change if needed
$password = "";
$dbname = "home_maintenance";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$experience = $_POST['experience'];
$location = $_POST['location'];

// Insert into database
$sql = "INSERT INTO electricians (name, email, phone, experience, location) 
        VALUES ('$name', '$email', '$phone', '$experience', '$location')";

if ($conn->query($sql) === TRUE) {
    echo "Registration successful!";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
