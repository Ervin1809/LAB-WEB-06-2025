<?php
/*
 * File: pm_tambah_proyek.php
 * Deskripsi: Memproses penambahan proyek baru oleh PM.
 */

require_once 'config.php';
require_once 'includes/auth_check.php';

// Proteksi: Hanya Project Manager
if ($_SESSION['role'] !== 'Project Manager') {
    die("Akses ditolak.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_proyek = $_POST['nama_proyek'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    $manager_id = $_SESSION['id']; // ID PM yang sedang login

    $stmt = $conn->prepare("INSERT INTO projects (nama_proyek, deskripsi, tanggal_mulai, tanggal_selesai, manager_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $nama_proyek, $deskripsi, $tanggal_mulai, $tanggal_selesai, $manager_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Proyek baru berhasil ditambahkan.";
        $_SESSION['msg_type'] = "success";
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