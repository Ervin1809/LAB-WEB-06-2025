<?php
session_start();
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'role' => $user['role']
        ];

        switch ($user['role']) {
            case 'ADMIN':
                header("Location: admin_dashboard.php");
                break;
            case 'MANAGER':
                header("Location: manager_dashboard.php");
                break;
            case 'MEMBER':
                header("Location: member_dashboard.php");
                break;
            default:
                $_SESSION['error'] = "Role tidak dikenali.";
                header("Location: login.php");
        }
        exit();
    } else {
        $_SESSION['error'] = "Username atau password salah!";
        header("Location: login.php");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>
