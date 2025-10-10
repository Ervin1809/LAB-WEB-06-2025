<?php
session_start();

require 'data.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user_found = null;

    foreach ($users as $user) {
        if ($user['username'] === $username) {
            $user_found = $user;
            break;
        }
    }

    if ($user_found && password_verify($password, $user_found['password'])) {
        $_SESSION['user'] = $user_found;
        header('Location: dashboard.php');
    } else {
        $_SESSION['error'] = 'Username atau password salah!';
        header('Location: login.php');
    }
} else {
    header('Location: login.php');
}
?>