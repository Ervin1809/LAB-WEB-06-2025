<?php
/*
 * File: proses_login.php
 * Deskripsi: Memproses data login dan validasi.
 */

require_once 'config.php';

// Cek apakah metode request adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password_input = $_POST['password'];

    // Siapkan query (Prepared Statement) untuk mengambil data user
    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password_input, $user['password'])) {
            // Login sukses
            // Simpan data ke session
            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Arahkan ke dashboard sesuai role
            if ($user['role'] == 'Super Admin') {
                header('Location: dashboard_admin.php');
            } elseif ($user['role'] == 'Project Manager') {
                header('Location: dashboard_pm.php');
            } elseif ($user['role'] == 'Team Member') {
                header('Location: dashboard_team.php');
            } else {
                // Role tidak dikenal
                $_SESSION['login_error'] = "Role pengguna tidak valid.";
                header('Location: login.php');
            }
            exit;

        } else {
            // Password salah
            $_SESSION['login_error'] = "Username atau password salah.";
            header('Location: login.php');
            exit;
        }
    } else {
        // Username tidak ditemukan
        $_SESSION['login_error'] = "Username atau password salah.";
        header('Location: login.php');
        exit;
    }

    $stmt->close();
} else {
    // Jika diakses langsung, kembalikan ke login
    header('Location: login.php');
    exit;
}

$conn->close();
?>