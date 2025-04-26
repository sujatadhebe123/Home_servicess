<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "home_maintenance";

// Connect to database
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from form
$user_name = $_POST['user_name'];
$contact = $_POST['contact'];
$service_type = $_POST['service_type'];
$worker_name = $_POST['worker_name'];
$complaint = $_POST['complaint'];

// Insert into complaints table
$stmt = $conn->prepare("INSERT INTO complaints (user_name, contact, service_type, worker_name, complaint) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $user_name, $contact, $service_type, $worker_name, $complaint);

if ($stmt->execute()) {
    echo "Complaint submitted successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
