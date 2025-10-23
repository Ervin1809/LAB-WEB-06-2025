<?php
/*
 * File: pm_update_tugas.php
 * Deskripsi: Memproses update tugas oleh PM.
 */

require_once 'config.php';
require_once 'includes/auth_check.php';

// Proteksi: Hanya Project Manager
if ($_SESSION['role'] !== 'Project Manager') {
    die("Akses ditolak.");
}

$pm_id = $_SESSION['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['task_id']) && isset($_POST['project_id'])) {
    
    $task_id = $_POST['task_id'];
    $project_id = $_POST['project_id'];
    $nama_tugas = $_POST['nama_tugas'];
    $deskripsi = $_POST['deskripsi'];
    $assigned_to = $_POST['assigned_to'];

    // Validasi: Pastikan PM ini adalah manajer dari proyek yg diinput
    $stmt_check = $conn->prepare("SELECT id FROM projects WHERE id = ? AND manager_id = ?");
    $stmt_check->bind_param("ii", $project_id, $pm_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    if ($result_check->num_rows === 0) {
        die("Akses ditolak. Proyek ini bukan milik Anda.");
    }
    $stmt_check->close();

    // --- Lolos Validasi ---
    
    // Query UPDATE
    $stmt = $conn->prepare("UPDATE tasks SET nama_tugas = ?, deskripsi = ?, assigned_to = ? WHERE id = ? AND project_id = ?");
    $stmt->bind_param("ssiii", $nama_tugas, $deskripsi, $assigned_to, $task_id, $project_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Tugas berhasil di-update.";
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
// Kembalikan ke halaman manajemen tugas
header('Location: pm_manajemen_tugas.php?project_id=' . $project_id);
exit;
?>