<?php
session_start();

// Panggil file data.php untuk mendapatkan array $users
require_once 'data.php';

// Ambil input dari form
$username = $_POST['username'];
$password = $_POST['password'];

$user_found = null;

// Cari user berdasarkan username di dalam array $users
foreach ($users as $user) { 
    if ($user['username'] === $username) {
        $user_found = $user;
        break;
    }
}

// Jika user ditemukan dan password cocok
if ($user_found && password_verify($password, $user_found['password'])) { 
    // Login berhasil, simpan data user ke session
    $_SESSION['user'] = $user_found; 
    header('Location: dashboard.php'); // Arahkan ke dashboard
    exit();
} else {
    // Login gagal, set pesan error dan kembalikan ke halaman login
    $_SESSION['error'] = "Username atau password salah!"; 
    header('Location: login.php');
    exit();
}