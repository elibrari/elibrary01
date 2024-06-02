<?php
require 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        if ($user) {
            // Debug: Check retrieved user
            echo 'User found: ' . htmlspecialchars($user['username']) . '<br>';

            // Verify the password
            if (password_verify($password, $user['password'])) {
                echo 'Password is valid!<br>'; // Debug: Password valid
                $_SESSION['user_id'] = $user['id'];
                header("Location:mainpage.html");
                exit();
            } else {
                echo 'Invalid password<br>'; // Debug: Invalid password
            }
        } else {
            echo 'Invalid username<br>'; // Debug: Invalid username
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>
