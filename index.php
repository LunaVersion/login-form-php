<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require 'connect.php';

try {
    $stmt = $pdo->prepare('SELECT name, email, last_logged_at, created_at FROM users WHERE id = :id');
    $stmt->execute(['id' => $_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h1>
    <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
    <p>Last Logged In: <?php echo htmlspecialchars($user['last_logged_at']); ?></p>
    <p>Account Created At: <?php echo htmlspecialchars($user['created_at']); ?></p>
    <form action="exeLogout.php" method="post">
        <button type="submit">Logout</button>
    </form>
</body>
</html>
