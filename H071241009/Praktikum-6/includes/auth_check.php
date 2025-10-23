<?php
/*
 * File: includes/auth_check.php
 * Deskripsi: Memeriksa apakah pengguna sudah login atau belum.
 * Wajib di-include di setiap halaman yang terproteksi.
 */

// Mulai session (pastikan config.php sudah dipanggil sebelumnya)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah pengguna sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Jika belum login, arahkan paksa ke halaman login
    header("location: login.php");
    exit;
}
?>