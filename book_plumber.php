<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "home_maintenance";

// Connect to DB
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit;
}

// Read JSON input
$data = json_decode(file_get_contents("php://input"), true);

// Validate data
if (!isset($data['id']) || empty($data['id'])) {
    echo json_encode(["error" => "Missing plumber ID"]);
    exit;
}

$plumberId = intval($data['id']);

// Get plumber details from the correct table: plumbers
$stmt = $conn->prepare("SELECT name, email FROM plumbers WHERE id = ?");
$stmt->bind_param("i", $plumberId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo json_encode(["error" => "Plumber not found"]);
    exit;
}

$plumber = $result->fetch_assoc();
$plumberName = $plumber['name'];
$plumberEmail = $plumber['email'];

// Load PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'sujatadhebe48@gmail.com'; // your email
    $mail->Password   = 'bydyydbjimudcerm'; // your app password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('sujatadhebe48@gmail.com', 'Admin');
    $mail->addAddress($plumberEmail, $plumberName);

    $mail->isHTML(true);
    $mail->Subject = "Plumber Booking Confirmation";
    $mail->Body    = "Hello $plumberName,<br><br>You have been booked for a plumbing service.<br><br>Please contact the user to confirm details.";

    $mail->send();
    echo json_encode(["success" => true]);
} catch (Exception $e) {
    echo json_encode(["error" => "Mailer Error: " . $mail->ErrorInfo]);
}

$stmt->close();
$conn->close();
?>
