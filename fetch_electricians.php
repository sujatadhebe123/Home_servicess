<?php
header('Content-Type: application/json');

$host = "localhost";
$username = "root";
$password = "";
$dbname = "home_maintenance";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit;
}

// Get location from query string
$location = isset($_GET['location']) ? trim($_GET['location']) : '';

if (empty($location)) {
    echo json_encode([]);
    exit;
}

// Prepare and execute the SQL query
$stmt = $conn->prepare("SELECT * FROM electricians WHERE location = ?");
$stmt->bind_param("s", $location);
$stmt->execute();
$result = $stmt->get_result();

// Fetch and output
$electricians = [];
while ($row = $result->fetch_assoc()) {
    $electricians[] = $row;
}

echo json_encode($electricians);

// Cleanup
$stmt->close();
$conn->close();
?>
