<?php
/*
 * File: team_update_status.php
 * Deskripsi: Memproses update status tugas oleh Team Member.
 */

require_once 'config.php';
require_once 'includes/auth_check.php';

// Proteksi: Hanya Team Member
if ($_SESSION['role'] !== 'Team Member') {
    die("Akses ditolak.");
}

$team_member_id = $_SESSION['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['task_id']) && isset($_POST['new_status'])) {
    
    $task_id = $_POST['task_id'];
    $new_status = $_POST['new_status'];

    // Validasi status
    $allowed_statuses = ['belum', 'proses', 'selesai'];
    if (!in_array($new_status, $allowed_statuses)) {
        $_SESSION['message'] = "Status tidak valid.";
        $_SESSION['msg_type'] = "danger";
        header('Location: dashboard_team.php');
        exit;
    }

    // Query UPDATE yang AMAN:
    // Hanya update tugas JIKA ID tugas cocok DAN assigned_to adalah ID user yg login
    $stmt = $conn->prepare("UPDATE tasks SET status = ? WHERE id = ? AND assigned_to = ?");
    $stmt->bind_param("sii", $new_status, $task_id, $team_member_id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $_SESSION['message'] = "Status tugas berhasil di-update.";
            $_SESSION['msg_type'] = "success";
        } else {
            // Ini bisa terjadi jika statusnya sama (misal 'belum' di-update ke 'belum')
            $_SESSION['message'] = "Tidak ada perubahan atau tugas tidak ditemukan.";
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
// Kembalikan ke dashboard team member
header('Location: dashboard_team.php');
exit;
?>