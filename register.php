<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    try {
        $stmt = $pdo->prepare("SELECT id FROM students WHERE name = :name LIMIT 1");
        $stmt->execute(['name' => $name]);
        if ($stmt->fetch()) {
            echo "Name already taken.";
        } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO students (name, email, password) VALUES (:name, :email, :password)");
                $stmt->execute([
                    'name' => $name,
                    'email' => $email,
                    'password' => $hashed_password
                ]);
            $success_message = "User Registered Successfully";
            header("Location: login.php");
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>
    <?php if (isset($error_message)):?>
        <p class="error"> <?= $error_message?> </p>
    <?php endif; ?>
    <?php if (isset($success_message)): ?>
        <p class="success"><?= $success_message ?> <a href="login.php">Login</a></p>
    <?php endif; ?>
    <form method="POST">
        <label>
            Name:
            <input type="text" name="name" required maxlength="100">
        </label>
        <br><br>
        <label>
            Email:
            <input type="email" name="email" required maxlength="100">
        </label>
        <br><br>
        <label>
            Password:
            <input type="password" name="password" required maxlength="100">
        </label>
        <br><br>
        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a></p>
</body>
</html>