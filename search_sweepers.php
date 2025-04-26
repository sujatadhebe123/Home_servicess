<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "home_maintenance";

// Connect to the database
$conn = new mysqli($host, $username, $password, $database);

// Check for connection error
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Get the location from query parameter
$location = isset($_GET['location']) ? trim($_GET['location']) : '';

if (!$location) {
    echo json_encode([]);
    exit;
}

// Prepare and execute the SQL query
$stmt = $conn->prepare("SELECT * FROM sweeper WHERE location = ?");
$stmt->bind_param("s", $location);
$stmt->execute();

$result = $stmt->get_result();
$sweepers = [];

while ($row = $result->fetch_assoc()) {
    $sweepers[] = $row;
}

// Return the result as JSON
echo json_encode($sweepers);

// Close connections
$stmt->close();
$conn->close();
?>
