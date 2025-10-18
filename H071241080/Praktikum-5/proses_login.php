<?php

session_start();

include 'data.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $input_username = isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '';
    $input_password = isset($_POST['password']) ? $_POST['password'] : '';
  
    $found_user = null;

    foreach ($users as $user) {
        if ($user['username'] === $input_username) {
            $found_user = $user;
            break; 
        }
    }

    if ($found_user && password_verify($input_password, $found_user['password'])) {
        unset($found_user['password']); 
        $_SESSION['user'] = $found_user; 

        header('Location: dashboard.php');
        exit;
        
    } else {
        $_SESSION['error'] = "Username atau password salah!"; 
  
        header('Location: login.php');
        exit;
    }

} else {
    header('Location: login.php');
    exit;
}
