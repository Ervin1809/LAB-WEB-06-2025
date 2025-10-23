<?php
/*
 * File: admin_tambah_user.php
 * Deskripsi: Memproses penambahan user baru oleh Super Admin.
 */

require_once 'config.php';
require_once 'includes/auth_check.php';

// Proteksi: Hanya Super Admin
if ($_SESSION['role'] !== 'Super Admin') {
    die("Akses ditolak.");
}

// Cek jika data dikirim via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Siapkan query
    $stmt = null;
    $project_manager_id = NULL;

    if ($role == 'Team Member') {
        // Cek apakah PM dipilih
        if (empty($_POST['project_manager_id'])) {
            $_SESSION['message'] = "Error: Team Member wajib memiliki Project Manager.";
            $_SESSION['msg_type'] = "danger";
            header('Location: dashboard_admin.php');
            exit;
        }
        $project_manager_id = $_POST['project_manager_id'];
        
        $stmt = $conn->prepare("INSERT INTO users (username, password, role, project_manager_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $username, $hashed_password, $role, $project_manager_id);

    } else if ($role == 'Project Manager') {
        $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $hashed_password, $role);
    
    } else {
        $_SESSION['message'] = "Error: Role tidak valid.";
        $_SESSION['msg_type'] = "danger";
        header('Location: dashboard_admin.php');
        exit;
    }

    // Eksekusi query
    if ($stmt->execute()) {
        $_SESSION['message'] = "User '$username' berhasil ditambahkan.";
        $_SESSION['msg_type'] = "success";
    } else {
        // Cek jika error karena username duplikat
        if ($conn->errno == 1062) { // 1062 adalah kode error untuk 'Duplicate entry'
            $_SESSION['message'] = "Error: Username '$username' sudah ada.";
        } else {
            $_SESSION['message'] = "Error: " . $stmt->error;
        }
        $_SESSION['msg_type'] = "danger";
    }
    
    $stmt->close();

} else {
    // Jika diakses langsung
    $_SESSION['message'] = "Aksi tidak valid.";
    $_SESSION['msg_type'] = "warning";
}

$conn->close();
// Kembalikan ke dashboard admin
header('Location: dashboard_admin.php');
exit;
?>