<?php

//dashboard.php
session_start();

if(empty($_SESSION['user_id'])){
    header('location:login.php');
    exit;
}

//retrive user's name and email

$name = $_SESSION['user_name'] ?? 'User';
$user_email = $_SESSION['user_email'] ?? 'Not provided';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>
        Welcome, <?=($name)?>
    </h1>
    <p>
        <a href="logout.php">Logout</a><br>
        <a href="upload.php">Upload</a>
    </p>

    <hr>

    <h2> Quick Account Info</h2>
    <ul>
        <li>User ID: <?=htmlspecialchars($_SESSION['user_id'])?></li>
        <li>Name: <?=htmlspecialchars($name)?></li>
        <li>Email: <?=htmlspecialchars($user_email)?></li>
    </ul>
</body>
</html>