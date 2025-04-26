<?php
// Simulating admin info (you can later fetch this from a database if needed)
$adminInfo = [
    "full_name" => " Sujata Soma Dhebe",
    "email" => "sujatadhebe48@gmail.com",
    "phone" => "8459958389",
    "address" => "Khopoli,Raigad, Maharashtra",
    "education" => "B.E in IT Engineering",
    "linkdin_profile"=>"https://www.linkedin.com/in/sujata-dhebe-6209a430b",
    "college"=>"Students of Dr.D.Y.Patil Engineering College Akurdi,Pune",
    "image" => "image/admin.jpeg" // Store this image in the same folder or use full path
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('https://tse2.mm.bing.net/th?id=OIP.jlZKoxfBr3VdIpCQph9TRwHaEK&pid=Api&P=0&h=180');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="text-gray-900 bg-opacity-70 backdrop-blur-md">
    <div class="max-w-4xl mx-auto mt-20 p-10 bg-white bg-opacity-90 shadow-2xl rounded-3xl">
        <h2 class="text-4xl font-bold mb-8 text-center text-blue-700">Admin Profile</h2>
        
        <div class="flex items-center space-x-10 mb-10">
            <img src="<?= $adminInfo['image'] ?>" alt="Profile Picture" class="w-40 h-40 rounded-full border-4 border-blue-500 object-cover shadow-lg">
            <div>
                <p class="text-3xl font-semibold"><?= $adminInfo['full_name'] ?></p>
                <p class="text-gray-600 text-xl"><?= $adminInfo['email'] ?></p>
            </div>
        </div>

        <div class="space-y-4 text-xl pl-4">
            <p><span class="font-semibold text-blue-600">Phone:</span> <?= $adminInfo['phone'] ?></p>
            <p><span class="font-semibold text-blue-600">Address:</span> <?= $adminInfo['address'] ?></p>
            <p><span class="font-semibold text-blue-600">Education:</span> <?= $adminInfo['education'] ?></p>
            <p><span class="font-semibold text-blue-600">LinkedIn Profile:</span> 
                <a href="<?= $adminInfo['linkdin_profile'] ?>" target="_blank" class="text-blue-500 underline hover:text-blue-700"><?= $adminInfo['linkdin_profile'] ?></a>
            </p>
            <p><span class="font-semibold text-blue-600">College:</span> <?= $adminInfo['college'] ?></p>
        </div>
    </div>
</body>
</html>
