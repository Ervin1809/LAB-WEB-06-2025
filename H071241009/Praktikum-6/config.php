<?php
/*
 * File: config.php
 * Deskripsi: File konfigurasi untuk koneksi database dan session.
 */

// Detail Koneksi Database
$servername = "localhost";    // Server database
$username_db = "root";      // Username database XAMPP default
$password_db = "";          // Password database XAMPP default
$database = "db_manajemen_proyek"; // Nama database Anda

// Buat koneksi
$conn = new mysqli($servername, $username_db, $password_db, $database);

// Cek koneksi
if ($conn->connect_error) {
  die("Koneksi database gagal: " . $conn->connect_error);
}

// Selalu mulai session di file konfigurasi
// agar variabel $_SESSION tersedia di semua halaman
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>