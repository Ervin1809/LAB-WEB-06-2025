<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Super Admin') {
    die("Akses ditolak");
}

$user_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($user_id === 0) {
    die("ID user tidak ditemukan");
}

$stmt = mysqli_prepare($conn, "SELECT id, username FROM users WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 0) {
    mysqli_stmt_close($stmt);
    die("User tidak ditemukan di database.");
}

$user = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

$stmt = mysqli_prepare($conn, "DELETE FROM users WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $user_id);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    header("Location: superadmin_dashboard.php?success=User+berhasil+dihapus");
    exit;

} else {
    mysqli_stmt_close($stmt);
    die("Gagal menghapus user: " . mysqli_error($conn));
}
?>
