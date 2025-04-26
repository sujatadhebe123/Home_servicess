<?php
session_start();

// Make sure the form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'config.php'; // DB connection

    // Collect data
    $name = $_POST['name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $email = $_POST['email'] ?? '';
    $address = $_POST['address'] ?? '';

    // Insert guest into database
    $sql = "INSERT INTO guests (name, phone, email, address) 
            VALUES ('$name', '$phone', '$email', '$address')";

    if ($conn->query($sql) === TRUE) {
        // Store guest ID in session (optional)
        $_SESSION['guest_id'] = $conn->insert_id;

        // ✅ Redirect to check_rooms.php
        header("Location: check_rooms.php");
        exit;
    } else {
        // Redirect with error if insert fails
        header("Location: guest_register.html?error=Something+went+wrong");
        exit;
    }

    $conn->close();
} else {
    // Redirect if accessed without form submit
    header("Location: guest_register.html");
    exit;
}
?>
