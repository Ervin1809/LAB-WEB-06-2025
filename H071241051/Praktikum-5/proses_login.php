<?php
session_start();
require_once 'data.php';

// Cek apakah form sudah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validasi input tidak kosong
    if (empty($username) || empty($password)) {
        $_SESSION['error'] = 'Username dan password harus diisi!';
        header('Location: login.php');
        exit;
    }

    // Cari user berdasarkan username
    $userFound = null;
    foreach ($users as $user) {
        if ($user['username'] === $username) {
            $userFound = $user;
            break;
        }
    }

    // Verifikasi user dan password
    if ($userFound && password_verify($password, $userFound['password'])) {
        // Login berhasil
        $_SESSION['user'] = $userFound;
        header('Location: dashboard.php');
        exit;
    } else {
        // Login gagal
        $_SESSION['error'] = 'Username atau password salah!';
        header('Location: login.php');
        exit;
    }
} else {
    // Jika diakses langsung tanpa POST, redirect ke login
    header('Location: login.php');
    exit;
}
?>