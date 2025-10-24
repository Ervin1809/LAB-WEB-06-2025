<?php
include 'koneksi.php'; // Include 'koneksi.php'

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Ambil SEMUA data user
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {
            
            // PERUBAHAN UTAMA: Simpan seluruh data user ke dalam satu array session
            $_SESSION['user'] = $user; 
            // -----------------------------------------------------------------

            // Redirect ke dashboard router
            header("Location: dashboard.php");
            exit();
        } else {
            header("Location: login.php?error=Username atau password salah");
            exit();
        }
    } else {
        header("Location: login.php?error=Username atau password salah");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>