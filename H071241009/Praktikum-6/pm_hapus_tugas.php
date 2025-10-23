<?php
/*
 * File: pm_hapus_tugas.php
 * Deskripsi: Memproses penghapusan tugas oleh PM.
 */

require_once 'config.php';
require_once 'includes/auth_check.php';

// Proteksi: Hanya Project Manager
if ($_SESSION['role'] !== 'Project Manager') {
    die("Akses ditolak.");
}

$pm_id = $_SESSION['id'];

// Validasi: Pastikan ID tugas dan ID Proyek ada
if (isset($_GET['id']) && isset($_GET['project_id'])) {
    $task_id = $_GET['id'];
    $project_id = $_GET['project_id']; // Dibutuhkan untuk redirect

    // Validasi SUPER PENTING:
    // Hapus tugas HANYA JIKA tugas itu ada di dalam proyek yg dimiliki PM ini.
    // Kita gunakan JOIN untuk mengecek kepemilikan.
    
    $stmt = $conn->prepare("DELETE t FROM tasks t 
                            JOIN projects p ON t.project_id = p.id
                            WHERE t.id = ? AND p.manager_id = ?");
    $stmt->bind_param("ii", $task_id, $pm_id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $_SESSION['message'] = "Tugas berhasil dihapus.";
            $_SESSION['msg_type'] = "success";
        } else {
            $_SESSION['message'] = "Tugas tidak ditemukan atau Anda tidak punya akses.";
            $_SESSION['msg_type'] = "danger";
        }
    } else {
        $_SESSION['message'] = "Error: " . $stmt->error;
        $_SESSION['msg_type'] = "danger";
    }
    $stmt->close();

} else {
    $_SESSION['message'] = "Aksi tidak valid: ID Tugas tidak ditemukan.";
    $_SESSION['msg_type'] = "warning";
}

$conn->close();
// Kembalikan ke halaman manajemen tugas SPESIFIK
header('Location: pm_manajemen_tugas.php?project_id=' . $project_id);
exit;
?>