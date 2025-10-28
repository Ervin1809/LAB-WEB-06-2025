<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user'])) {
    die("Akses ditolak");
}

$id = $_GET['id'] ?? 0;

if ($_SESSION['user']['role'] === 'Project Manager') {
    $manager_id = $_SESSION['user']['id'];
    $sql = "DELETE FROM projects WHERE id=? AND manager_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $id, $manager_id);

} elseif ($_SESSION['user']['role'] === 'Super Admin') {
    $sql = "DELETE FROM projects WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);

} else {
    die("Akses ditolak");
}

if (mysqli_stmt_execute($stmt)) {
    if ($_SESSION['user']['role'] === 'Super Admin') {
        header("Location: superadmin_dashboard.php");
    } else {
        header("Location: manager_dashboard.php");
    }
    exit();
} else {
    echo "Gagal menghapus proyek: " . mysqli_error($conn);
}
?>
