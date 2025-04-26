<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'sujatadhebe48@gmail.com';  // 🔹 Admin Email
    $mail->Password   = 'bydyydbjimudcerm';       // 🔹 Gmail App Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // ✅ Ensure form data is received
    if (!isset($_POST['name'], $_POST['email'], $_POST['message'])) {
        echo "Error: Please fill in all fields.";
        exit;
    }

    // ✅ Sanitize user input
    $name = trim(htmlspecialchars($_POST['name']));
    $email = trim(htmlspecialchars($_POST['email']));
    $message = trim(htmlspecialchars($_POST['message']));

    // ✅ Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Error: Invalid email address.";
        exit;
    }

    // ✅ Set sender and recipient
    $mail->setFrom('sujatadhebe48@gmail.com', 'Website Contact'); 
    $mail->addAddress('sujatadhebe48@gmail.com', 'Admin'); // Admin email
    $mail->addReplyTo($email, $name);  // User email for reply

    // ✅ Email content
    $mail->isHTML(true);
    $mail->Subject = 'New Contact Message';
    $mail->Body    = "Name: $name <br>Email: $email <br>Message: $message";

    $mail->send();
    echo 'Message has been sent!';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
