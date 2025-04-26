<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.html");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "home_maintenance";

// DB connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM complaints ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Complaints</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #89f7fe 0%, #66a6ff 100%);
            font-family: 'Segoe UI', sans-serif;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        table {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            overflow: hidden;
        }
        th {
            background-color: rgba(243, 244, 246, 0.9);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">

    <div class="glass-card max-w-6xl w-full">
        <h2 class="text-3xl font-bold text-center text-white mb-6">User Complaints</h2>

        <?php if ($result->num_rows > 0): ?>
        <div class="overflow-x-auto">
        <table class="table-auto w-full border">
            <thead>
                <tr>
                    <th class="px-4 py-2 border">ID</th>
                    <th class="px-4 py-2 border">Name</th>
                    <th class="px-4 py-2 border">Contact</th>
                    <th class="px-4 py-2 border">Service Type</th>
                    <th class="px-4 py-2 border">Worker</th>
                    <th class="px-4 py-2 border">Complaint</th>
                    <th class="px-4 py-2 border">Submitted At</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr class="hover:bg-gray-100">
                    <td class="border px-4 py-2"><?= htmlspecialchars($row['id']) ?></td>
                    <td class="border px-4 py-2"><?= htmlspecialchars($row['user_name']) ?></td>
                    <td class="border px-4 py-2"><?= htmlspecialchars($row['contact']) ?></td>
                    <td class="border px-4 py-2"><?= htmlspecialchars($row['service_type']) ?></td>
                    <td class="border px-4 py-2"><?= htmlspecialchars($row['worker_name']) ?></td>
                    <td class="border px-4 py-2"><?= htmlspecialchars($row['complaint']) ?></td>
                    <td class="border px-4 py-2"><?= htmlspecialchars($row['created_at']) ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        </div>
        <?php else: ?>
            <p class="text-white text-center">No complaints found.</p>
        <?php endif; ?>

        <div class="text-center mt-6">
            <a href="logoutadmin.php" class="inline-block px-6 py-2 bg-red-500 text-white rounded-lg font-semibold hover:bg-red-600 transition">Logout</a>
        </div>
    </div>

</body>
</html>

<?php $conn->close(); ?>
