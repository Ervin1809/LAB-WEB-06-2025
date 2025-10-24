<?php
require 'koneksi.php';

if (!isset($_SESSION['user'])) {
    die("Akses ditolak");
}

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$project_id_to_delete = (int)$_GET['id'];
$user_role = $_SESSION['user']['role'];
$user_id = (int)$_SESSION['user']['id'];

mysqli_begin_transaction($conn);

try {
    // Hapus dulu semua tasks di dalam proyek ini
    $sql_tasks = "DELETE FROM tasks WHERE project_id = ?";
    $stmt_tasks = mysqli_prepare($conn, $sql_tasks);
    mysqli_stmt_bind_param($stmt_tasks, "i", $project_id_to_delete);
    mysqli_stmt_execute($stmt_tasks);

    // Sekarang hapus proyeknya
    if ($user_role === 'Super Admin') {
        // Super Admin boleh hapus proyek apa saja
        $sql_proj = "DELETE FROM projects WHERE id = ?";
        $stmt_proj = mysqli_prepare($conn, $sql_proj);
        mysqli_stmt_bind_param($stmt_proj, "i", $project_id_to_delete);
    } elseif ($user_role === 'Project Manager') {
        // PM hanya boleh hapus proyek miliknya
        $sql_proj = "DELETE FROM projects WHERE id = ? AND manager_id = ?";
        $stmt_proj = mysqli_prepare($conn, $sql_proj);
        mysqli_stmt_bind_param($stmt_proj, "ii", $project_id_to_delete, $user_id);
    } else {
        die("Akses ditolak");
    }

    mysqli_stmt_execute($stmt_proj);
    
    // Commit transaksi
    mysqli_commit($conn);

} catch (Exception $e) {
    mysqli_rollback($conn);
    die("Gagal menghapus proyek: " . $e->getMessage());
}

// Redirect kembali ke dashboard yang sesuai
if ($user_role === 'Super Admin') {
    header("Location: superadmin_dashboard.php");
} else {
    header("Location: manager_dashboard.php");
}
exit();
?>