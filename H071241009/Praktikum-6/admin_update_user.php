<?php
/*
 * File: admin_update_user.php
 * Deskripsi: Memproses update user oleh Super Admin.
 */

require_once 'config.php';
require_once 'includes/auth_check.php';

// Proteksi: Hanya Super Admin
if ($_SESSION['role'] !== 'Super Admin') {
    die("Akses ditolak.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'])) {
    
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $password = $_POST['password']; // Password baru (bisa kosong)
    $role = $_POST['role'];
    
    $project_manager_id = NULL;
    if ($role == 'Team Member') {
        if (empty($_POST['project_manager_id'])) {
            $_SESSION['message'] = "Error: Team Member wajib memiliki Project Manager.";
            $_SESSION['msg_type'] = "danger";
            header('Location: admin_edit_user.php?id=' . $user_id);
            exit;
        }
        $project_manager_id = $_POST['project_manager_id'];
    }

    // Cek jika Super Admin mencoba mengedit dirinya sendiri dan mengubah rolenya
    if ($user_id == $_SESSION['id'] && $role != 'Super Admin') {
         $_SESSION['message'] = "Error: Anda tidak bisa mengubah role Anda sendiri.";
         $_SESSION['msg_type'] = "danger";
         header('Location: admin_edit_user.php?id=' . $user_id);
         exit;
    }

    // Query dinamis: Cek apakah password diisi atau tidak
    if (!empty($password)) {
        // Jika password diisi, update password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET username = ?, password = ?, role = ?, project_manager_id = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $username, $hashed_password, $role, $project_manager_id, $user_id);
    } else {
        // Jika password kosong, JANGAN update password
        $stmt = $conn->prepare("UPDATE users SET username = ?, role = ?, project_manager_id = ? WHERE id = ?");
        $stmt->bind_param("sssi", $username, $role, $project_manager_id, $user_id);
    }

    // Eksekusi query
    if ($stmt->execute()) {
        $_SESSION['message'] = "User '$username' berhasil di-update.";
        $_SESSION['msg_type'] = "success";
    } else {
        if ($conn->errno == 1062) { // Error username duplikat
            $_SESSION['message'] = "Error: Username '$username' sudah ada.";
            $_SESSION['msg_type'] = "danger";
            header('Location: admin_edit_user.php?id=' . $user_id);
            exit;
        } else {
            $_SESSION['message'] = "Error: " . $stmt->error;
            $_SESSION['msg_type'] = "danger";
        }
    }
    
    $stmt->close();

} else {
    $_SESSION['message'] = "Aksi tidak valid.";
    $_SESSION['msg_type'] = "warning";
}

$conn->close();
header('Location: dashboard_admin.php');
exit;
?>