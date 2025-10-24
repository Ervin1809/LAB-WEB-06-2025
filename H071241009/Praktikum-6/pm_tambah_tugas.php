<?php
/*
 * File: pm_tambah_tugas.php
 * Deskripsi: Memproses penambahan tugas baru oleh PM.
 */

require_once 'config.php';
require_once 'includes/auth_check.php';

// Proteksi: Hanya Project Manager
if ($_SESSION['role'] !== 'Project Manager') {
    die("Akses ditolak.");
}

$pm_id = $_SESSION['id'];
$project_id = $_POST['project_id']; // Ambil project_id dari form

// Validasi Cepat: Pastikan PM ini adalah manajer dari proyek yg diinput
$stmt_check = $conn->prepare("SELECT id FROM projects WHERE id = ? AND manager_id = ?");
$stmt_check->bind_param("ii", $project_id, $pm_id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();
if ($result_check->num_rows === 0) {
    die("Akses ditolak. Proyek ini bukan milik Anda.");
}
$stmt_check->close();

// --- Lolos Validasi ---

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_tugas = $_POST['nama_tugas'];
    $deskripsi = $_POST['deskripsi'];
    $assigned_to = $_POST['assigned_to'];
    // Status default adalah 'belum' (sesuai database)

    $stmt = $conn->prepare("INSERT INTO tasks (nama_tugas, deskripsi, project_id, assigned_to) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssii", $nama_tugas, $deskripsi, $project_id, $assigned_to);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Tugas baru berhasil ditambahkan.";
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
// Kembalikan ke halaman manajemen tugas SPESIFIK untuk proyek itu
header('Location: pm_manajemen_tugas.php?project_id=' . $project_id);
exit;
?>