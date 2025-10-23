<?php
/*
 * File: login.php
 * Deskripsi: Halaman login pengguna.
 */
require_once 'config.php';

// Jika sudah login, arahkan ke dashboard yang sesuai
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    if ($_SESSION['role'] == 'Super Admin') {
        header('Location: dashboard_admin.php');
    } elseif ($_SESSION['role'] == 'Project Manager') {
        header('Location: dashboard_pm.php');
    } else {
        header('Location: dashboard_team.php');
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Manajemen Proyek</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container">
        <div class="row justify-content-center" style="margin-top: 100px;">
            <div class="col-md-5">
                <div class="card shadow">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4">Login Sistem</h3>

                        <?php if(isset($_SESSION['login_error'])): ?>
                            <div class="alert alert-danger">
                                <?php
                                    echo $_SESSION['login_error'];
                                    unset($_SESSION['login_error']); // Hapus pesan setelah ditampilkan
                                ?>
                            </div>
                        <?php endif; ?>

                        <form action="proses_login.php" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>