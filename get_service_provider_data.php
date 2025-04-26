<?php
header('Content-Type: application/json');

// Database connection
$conn = new mysqli("localhost", "root", "", "home_maintenance");

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Categories and their table names
$tables = [
    'Plumber' => 'plumbers',
    'Electrician' => 'electricians',
    
    'Clothing' => 'clothing',
    'Sweeper'=>'sweeper'
];

$data = [];

foreach ($tables as $label => $table) {
    $sql = "SELECT COUNT(*) as count FROM `$table`";
    $result = $conn->query($sql);
    if ($result) {
        $row = $result->fetch_assoc();
        $data[$label] = (int)$row['count'];
    } else {
        $data[$label] = 0;
    }
}

$conn->close();

echo json_encode($data);
?>
