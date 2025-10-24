<?php
require 'koneksi.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Super Admin') {
    die("Akses ditolak");
}

if (!isset($_GET['id'])) {
    header("Location: superadmin_dashboard.php");
    exit();
}

$user_id_to_delete = (int)$_GET['id'];
$current_user_id = (int)$_SESSION['user']['id'];

if ($user_id_to_delete === $current_user_id) {
    die("Anda tidak bisa menghapus diri sendiri.");
}

// Dapatkan role user yang akan dihapus
$sql_role = "SELECT role FROM users WHERE id = ?";
$stmt_role = mysqli_prepare($conn, $sql_role);
mysqli_stmt_bind_param($stmt_role, "i", $user_id_to_delete);
mysqli_stmt_execute($stmt_role);
$result_role = mysqli_stmt_get_result($stmt_role);
$user_to_delete = mysqli_fetch_assoc($result_role);

if (!$user_to_delete) {
     header("Location: superadmin_dashboard.php");
     exit();
}

$role_to_delete = $user_to_delete['role'];

// Mulai transaksi
mysqli_begin_transaction($conn);

try {
    if ($role_to_delete === 'Project Manager') {
        // 1. Hapus tasks dari proyek yg dipegang PM ini
        $sql1 = "DELETE FROM tasks WHERE project_id IN (SELECT id FROM projects WHERE manager_id = ?)";
        $stmt1 = mysqli_prepare($conn, $sql1);
        mysqli_stmt_bind_param($stmt1, "i", $user_id_to_delete);
        mysqli_stmt_execute($stmt1);

        // 2. Hapus proyek yg dipegang PM ini
        $sql2 = "DELETE FROM projects WHERE manager_id = ?";
        $stmt2 = mysqli_prepare($conn, $sql2);
        mysqli_stmt_bind_param($stmt2, "i", $user_id_to_delete);
        mysqli_stmt_execute($stmt2);

        // 3. Set NULL untuk Team Member yang dipegang PM ini
        $sql3 = "UPDATE users SET project_manager_id = NULL WHERE project_manager_id = ?";
        $stmt3 = mysqli_prepare($conn, $sql3);
        mysqli_stmt_bind_param($stmt3, "i", $user_id_to_delete);
        mysqli_stmt_execute($stmt3);
    } 
    elseif ($role_to_delete === 'Team Member') {
        // 1. Hapus tasks yang di-assign ke member ini
        $sql1 = "DELETE FROM tasks WHERE assigned_to = ?";
        $stmt1 = mysqli_prepare($conn, $sql1);
        mysqli_stmt_bind_param($stmt1, "i", $user_id_to_delete);
        mysqli_stmt_execute($stmt1);
    }
    
    // Hapus user itu sendiri
    $sql_del_user = "DELETE FROM users WHERE id = ?";
    $stmt_del_user = mysqli_prepare($conn, $sql_del_user);
    mysqli_stmt_bind_param($stmt_del_user, "i", $user_id_to_delete);
    mysqli_stmt_execute($stmt_del_user);

    // Jika semua berhasil
    mysqli_commit($conn);
    
} catch (Exception $e) {
    // Jika ada error
    mysqli_rollback($conn);
    die("Gagal menghapus user: " . $e->getMessage());
}

header("Location: superadmin_dashboard.php");
exit();
?>