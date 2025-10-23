<?php
/*
 * File: pm_hapus_proyek.php
 * Deskripsi: Memproses penghapusan proyek oleh PM.
 */

require_once 'config.php';
require_once 'includes/auth_check.php';

// Proteksi: Hanya Project Manager
if ($_SESSION['role'] !== 'Project Manager') {
    die("Akses ditolak.");
}

if (isset($_GET['id'])) {
    $project_id = $_GET['id'];
    $manager_id = $_SESSION['id']; // ID PM yang sedang login

    // Hapus proyek HANYA JIKA ID dan manager_id sesuai
    // Karena ada relasi 'ON DELETE CASCADE' di database,
    // menghapus proyek ini juga akan menghapus semua 'tasks' terkait.
    $stmt = $conn->prepare("DELETE FROM projects WHERE id = ? AND manager_id = ?");
    $stmt->bind_param("ii", $project_id, $manager_id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $_SESSION['message'] = "Proyek (dan semua tugas di dalamnya) berhasil dihapus.";
            $_SESSION['msg_type'] = "success";
        } else {
            $_SESSION['message'] = "Proyek tidak ditemukan atau Anda tidak punya akses.";
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
header('Location: dashboard_pm.php');
exit;
?>