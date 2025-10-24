<?php
include 'koneksi.php'; 

// Cek apakah user sudah login menggunakan format session baru
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['user']['role'];

// Arahkan (redirect) user ke halaman yang sesuai dengan rolenya
switch ($role) {
    case 'Super Admin':
        header("Location: superadmin_dashboard.php");
        exit();
    case 'Project Manager':
        header("Location: manager_dashboard.php"); 
        exit();
    case 'Team Member':
        header("Location: member_dashboard.php"); 
        exit();
    default:
        // Jika role tidak jelas, logout saja
        header("Location: logout.php");
        exit();
}
?>