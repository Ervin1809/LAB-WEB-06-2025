<?php
session_start();

// Panggil file data.php untuk menampilkan semua data (khusus admin)
require_once 'data.php';

// Lindungi halaman: jika tidak ada session 'user', tendang ke halaman login
if (!isset($_SESSION['user'])) { 
    header('Location: login.php'); 
    exit();
}

// Ambil data user yang sedang login dari session
$loggedInUser = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="dashboard-container">
        <?php if ($loggedInUser['username'] === 'adminxxx') : ?>
            <h1>Selamat Datang, Admin!</h1> 
            <a href="logout.php">Logout</a> 
            
            <h2>Data Semua Pengguna</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td><?= htmlspecialchars($user['name']) ?></td>
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php else : ?>
            <h1>Selamat Datang, <?= htmlspecialchars($loggedInUser['name']) ?>!</h1> 
            <a href="logout.php">Logout</a> 

            <h2>Data Anda</h2>
            <table class="user-data">
                <tr>
                    <th>Nama</th>
                    <td><?= htmlspecialchars($loggedInUser['name']) ?></td>
                </tr>
                <tr>
                    <th>Username</th>
                    <td><?= htmlspecialchars($loggedInUser['username']) ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?= htmlspecialchars($loggedInUser['email']) ?></td>
                </tr>
                <tr>
                    <th>Gender</th>
                    <td><?= htmlspecialchars($loggedInUser['gender']) ?></td>
                </tr>
                 <tr>
                    <th>Fakultas</th>
                    <td><?= htmlspecialchars($loggedInUser['faculty']) ?></td>
                </tr>
                <tr>
                    <th>Angkatan</th>
                    <td><?= htmlspecialchars($loggedInUser['batch']) ?></td>
                </tr>
            </table>

        <?php endif; ?>
    </div>
</body>
</html>