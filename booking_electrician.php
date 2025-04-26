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

// Validate input
if (!isset($data['id']) || empty($data['id'])) {
    echo json_encode(["error" => "Missing electrician ID"]);
    exit;
}
if (!isset($data['phone']) || trim($data['phone']) === '') {
    echo json_encode(["error" => "Phone number is required."]);
    exit;
}

$electricianId = intval($data['id']);
$userPhone = htmlspecialchars(trim($data['phone']));

// Get electrician details
$stmt = $conn->prepare("SELECT name, email FROM electricians WHERE id = ?");
$stmt->bind_param("i", $electricianId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo json_encode(["error" => "Electrician not found"]);
    exit;
}

$electrician = $result->fetch_assoc();
$electricianName = $electrician['name'];
$electricianEmail = $electrician['email'];

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
    $mail->Password   = 'bydyydbjimudcerm';        // App password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('sujatadhebe48@gmail.com', 'Admin');
    $mail->addAddress($electricianEmail, $electricianName);

    $mail->isHTML(true);
    $mail->Subject = "Electrician Booking Confirmation";
    $mail->Body    = "Hello $electricianName,<br><br>You have been booked for an electrical service.<br><br><strong>User Phone:</strong> $userPhone<br><br>Please contact the user to confirm details.";

    $mail->send();
    echo json_encode(["success" => true]);
} catch (Exception $e) {
    echo json_encode(["error" => "Mailer Error: " . $mail->ErrorInfo]);
}

$stmt->close();
$conn->close();
?>
