<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "home_maintenance";

// Connect to the database
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Get location from query string
$location = isset($_GET['location']) ? $_GET['location'] : '';

if (!$location) {
    echo json_encode([]);
    exit;
}

// Prepare and execute the SQL query (case-insensitive)
$stmt = $conn->prepare("SELECT * FROM electricians WHERE LOWER(location) = LOWER(?)");
$stmt->bind_param("s", $location);
$stmt->execute();

$result = $stmt->get_result();
$electricians = [];

while ($row = $result->fetch_assoc()) {
    $electricians[] = $row;
}

// Return JSON response
echo json_encode($electricians);

// Close everything
$stmt->close();
$conn->close();
?>
