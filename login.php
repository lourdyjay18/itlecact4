<?php

include 'db.php';
session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $password = trim($_POST['password']);
    try{
        $stmt = $pdo->prepare("SELECT * FROM students WHERE name = :name AND password = :password LIMIT 1");
        $stmt->execute(['name' => $name, 'password' => $password]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if($user){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            header("Location: dashboard.php");
            exit();
    } else {
            $error_message = "Invalid name or password.";
        }
    } catch (PDOException $e) {
        echo " Database Error: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form method="POST">
        <label>
            Name:
            <input type="text" name="name" required maxlength="100">
        </label>
        <br><br>
        <label>
            Password:
            <input type="password" name="password" required maxlength="100">
        </label>
        <br><br>
        <button type="submit">Login</button>
        <a href="register.php"> Register </a>

    </form>
</body>
</html>