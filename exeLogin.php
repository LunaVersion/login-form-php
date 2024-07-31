<?php
session_start();
require 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare('SELECT id, password FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $email;

            // Cập nhật last_logged_at
            $stmt = $pdo->prepare('UPDATE users SET last_logged_at = NOW() WHERE id = :id');
            $stmt->execute(['id' => $user['id']]);

            header("Location: index.php");
            exit();
        } else {
            echo '<span style="color:red;">Invalid email or password.</span>';
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
