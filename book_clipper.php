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
if (!isset($data['id']) || !isset($data['userPhone']) || empty($data['id']) || empty($data['userPhone'])) {
    echo json_encode(["error" => "Missing clipper ID or user phone number"]);
    exit;
}

$clipperId = intval($data['id']);
$userPhone = htmlspecialchars($data['userPhone']);

// Get clipper details
$stmt = $conn->prepare("SELECT name, email FROM clipper WHERE id = ?");
$stmt->bind_param("i", $clipperId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo json_encode(["error" => "Clipper not found"]);
    exit;
}

$clipper = $result->fetch_assoc();
$clipperName = $clipper['name'];
$clipperEmail = $clipper['email'];

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
    $mail->Username   = 'sujatadhebe48@gmail.com'; // Your email
    $mail->Password   = 'bydyydbjimudcerm'; // App password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('sujatadhebe48@gmail.com', 'Admin');
    $mail->addAddress($clipperEmail, $clipperName);

    $mail->isHTML(true);
    $mail->Subject = "Clipping Booking Confirmation";
    $mail->Body    = "Hello $clipperName,<br><br>You have been booked for a clipping service.<br><strong>User's Phone:</strong> $userPhone<br><br>Please contact the user to confirm details.";

    $mail->send();
    echo json_encode(["success" => true]);
} catch (Exception $e) {
    echo json_encode(["error" => "Mailer Error: " . $mail->ErrorInfo]);
}

// Close connections
$stmt->close();
$conn->close();
?>
