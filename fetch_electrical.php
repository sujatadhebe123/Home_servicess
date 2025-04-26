<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "home_maintenance";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Database Connection Failed: " . $conn->connect_error]));
}

// Get location from request
$location = isset($_GET['location']) ? trim($_GET['location']) : '';

if (empty($location)) {
    echo json_encode(["error" => "Location is required"]);
    exit;
}

// Debugging: Check if input is received correctly
error_log("Searching for electricians in: " . $location);

// Query to fetch electricians based on location
$sql = "SELECT id, name, experience, phone FROM electricians WHERE location LIKE ?";
$stmt = $conn->prepare($sql);
$searchLocation = "%$location%";
$stmt->bind_param("s", $searchLocation);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    $electricians = $result->fetch_all(MYSQLI_ASSOC);

    // Debugging: Check fetched data
    error_log("Found electricians: " . json_encode($electricians));

    echo json_encode($electricians);
} else {
    echo json_encode(["error" => "Query execution failed: " . $stmt->error]);
}

// Close connection
$stmt->close();
$conn->close();
?>

