<?php
/*
 * File: buat_admin_awal.php
 * Deskripsi: Skrip untuk membuat Super Admin pertama.
 * PENTING: HAPUS FILE INI SETELAH DIJALANKAN!
 */

require_once 'config.php';

// Data Super Admin Awal
$username = "superadmin";
$password = "admin123"; // Ganti dengan password yang kuat
$role = "Super Admin"; // Sesuai instruksi [cite: 71]

// Hash password untuk keamanan
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Siapkan query (Prepared Statement untuk keamanan)
$stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $hashed_password, $role);

// Eksekusi
if ($stmt->execute()) {
    echo "Super Admin '$username' berhasil dibuat dengan password '$password'.<br>";
    echo "<b>SEKARANG HAPUS FILE INI (buat_admin_awal.php)!</b>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>