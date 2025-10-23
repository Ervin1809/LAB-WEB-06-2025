<?php
/*
 * File: pm_edit_proyek.php
 * Deskripsi: Memproses update proyek oleh PM.
 */

require_once 'config.php';
require_once 'includes/auth_check.php';

// Proteksi: Hanya Project Manager
if ($_SESSION['role'] !== 'Project Manager') {
    die("Akses ditolak.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['project_id'])) {
    $project_id = $_POST['project_id'];
    $nama_proyek = $_POST['nama_proyek'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    $manager_id = $_SESSION['id']; // ID PM yang sedang login

    // Query UPDATE, pastikan update proyek yang ID-nya dan manager_id-nya sesuai
    $stmt = $conn->prepare("UPDATE projects SET nama_proyek = ?, deskripsi = ?, tanggal_mulai = ?, tanggal_selesai = ? WHERE id = ? AND manager_id = ?");
    $stmt->bind_param("ssssii", $nama_proyek, $deskripsi, $tanggal_mulai, $tanggal_selesai, $project_id, $manager_id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $_SESSION['message'] = "Proyek berhasil di-update.";
            $_SESSION['msg_type'] = "success";
        } else {
            $_SESSION['message'] = "Tidak ada perubahan data atau proyek tidak ditemukan.";
            $_SESSION['msg_type'] = "warning";
        }
    } else {
        $_SESSION['message'] = "Error: " . $stmt->error;
        $_SESSION['msg_type'] = "danger";
    }
    $stmt->close();
} else {
    $_SESSION['message'] = "Aksi tidak valid.";
    $_SESSION['msg_type'] = "warning";
}

$conn->close();
header('Location: dashboard_pm.php');
exit;
?>