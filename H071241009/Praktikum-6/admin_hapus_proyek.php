<?php
/*
 * File: admin_hapus_proyek.php
 * Deskripsi: Memproses penghapusan proyek APAPUN oleh Super Admin.
 */

require_once 'config.php';
require_once 'includes/auth_check.php';

// Proteksi: Hanya Super Admin
if ($_SESSION['role'] !== 'Super Admin') {
    die("Akses ditolak.");
}

if (isset($_GET['id'])) {
    $project_id = $_GET['id'];

    // Super Admin bisa menghapus proyek apa saja, tidak perlu cek manager_id
    // Relasi 'ON DELETE CASCADE' di database akan otomatis menghapus semua 'tasks'
    // yang terhubung dengan project_id ini.
    
    $stmt = $conn->prepare("DELETE FROM projects WHERE id = ?");
    $stmt->bind_param("i", $project_id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $_SESSION['message'] = "Proyek (dan semua tugas di dalamnya) berhasil dihapus.";
            $_SESSION['msg_type'] = "success";
        } else {
            $_SESSION['message'] = "Proyek tidak ditemukan.";
            $_SESSION['msg_type'] = "danger";
        }
    } else {
        $_SESSION['message'] = "Error: " . $stmt->error;
        $_SESSION['msg_type'] = "danger";
    }
    $stmt->close();
} else {
    $_SESSION['message'] = "Aksi tidak valid: ID Proyek tidak ditemukan.";
    $_SESSION['msg_type'] = "warning";
}

$conn->close();
// Kembalikan ke dashboard admin
header('Location: dashboard_admin.php');
exit;
?>