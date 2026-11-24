<?php
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if ($name && filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $stmt = $pdo->prepare(
            "INSERT INTO users (name, email, password) VALUES (?, ?, ?)"
        );

        try {
            $stmt->execute([$name, $email, $password]);
            header("Location: login.php");
            exit;
        } catch (PDOException $e) {
            echo "Email already exists.";
        }

    } else {
        echo "Enter valid details.";
    }
}
?>

<h2>Register</h2>

<form method="POST">
    <input name="name" placeholder="Full Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Register</button>
</form>

<a href="login.php">Login</a>