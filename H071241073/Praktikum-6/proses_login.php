<?php
session_start();
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // gunakan name baru
    $username = trim($_POST['user_login']);
    $password = trim($_POST['pass_login']);

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
            case 'Super Admin':
                header("Location: superadmin_dashboard.php");
                break;
            case 'Project Manager':
                header("Location: manager_dashboard.php");
                break;
            case 'Team Member':
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
