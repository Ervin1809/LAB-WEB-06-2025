<?php
// Mulai session di sini agar semua file yang meng-include config
// otomatis memulai session.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Detail koneksi database
$DB_HOST = 'localhost';
$DB_USER = 'root'; // User default XAMPP
$DB_PASS = '';     // Password default XAMPP
$DB_NAME = 'db_manajemen_proyek';

// Buat koneksi
$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

// Cek koneksi
if (!$conn) {
    die("Koneksi Gagal: " . mysqli_connect_error());
}
?>