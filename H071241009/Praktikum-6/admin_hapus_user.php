<?php
/*
 * File: admin_hapus_user.php
 * Deskripsi: Memproses penghapusan user oleh Super Admin.
 */

require_once 'config.php';
require_once 'includes/auth_check.php';

// Proteksi: Hanya Super Admin
if ($_SESSION['role'] !== 'Super Admin') {
    die("Akses ditolak.");
}

// Cek jika ID ada di URL
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Validasi agar Super Admin tidak bisa menghapus dirinya sendiri
    if ($user_id == $_SESSION['id']) {
        $_SESSION['message'] = "Error: Anda tidak bisa menghapus akun Anda sendiri.";
        $_SESSION['msg_type'] = "danger";
    } else {
        // Siapkan query hapus
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);

        if ($stmt->execute()) {
            $_SESSION['message'] = "User berhasil dihapus.";
            $_SESSION['msg_type'] = "success";
        } else {
            $_SESSION['message'] = "Error: " . $stmt->error;
            $_SESSION['msg_type'] = "danger";
        }
        $stmt->close();
    }

} else {
    $_SESSION['message'] = "Aksi tidak valid: ID User tidak ditemukan.";
    $_SESSION['msg_type'] = "warning";
}

$conn->close();
// Kembalikan ke dashboard admin
header('Location: dashboard_admin.php');
exit;
?>