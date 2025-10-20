<?php
session_start();
require 'data.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #e0f7fa, #f2f6fc);
    padding: 40px;
    margin: 0;
}
.container {
    max-width: 1000px;
    margin: auto;
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    padding: 30px 40px;
}
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 3px solid #179a9a;
    padding-bottom: 10px;
    margin-bottom: 20px;
}
.header h2 {
    color: #179a9a;
    font-weight: 600;
}
.logout {
    background-color: #ff4b5c;
    color: white;
    padding: 8px 16px;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    transition: 0.3s;
}
.logout:hover {
    background-color: #c0392b;
    transform: scale(1.05);
}
h3 {
    color: #333;
    margin-top: 30px;
    border-left: 5px solid #179a9a;
    padding-left: 10px;
}
table {
    border-collapse: collapse;
    width: 100%;
    margin-top: 15px;
    border-radius: 8px;
    overflow: hidden;
}
th, td {
    border: 1px solid #eee;
    padding: 12px 14px;
    text-align: left;
}
th {
    background-color: #179a9a;
    color: white;
    text-transform: uppercase;
    font-size: 14px;
}
tr:nth-child(even) {
    background-color: #f8f9fa;
}
tr:hover {
    background-color: #e0f7fa;
    transition: 0.2s;
}
td {
    color: #333;
    font-size: 15px;
}
@media (max-width: 700px) {
    body { padding: 20px; }
    .container { padding: 20px; }
    table, tr, td, th { font-size: 13px; }
}
</style>
</head>
<body>
<div class="container">
    <div class="header">
        <h2>
            <?php if ($user['username'] === 'adminxxx'): ?>
                Selamat Datang, <strong>Admin!</strong>
            <?php else: ?>
                Selamat Datang, </span><strong><?= htmlspecialchars($user['name']); ?>!</strong>
            <?php endif; ?>
        </h2>
        <a href="logout.php" class="logout">Logout</a>
    </div>

    <?php if ($user['username'] === 'adminxxx'): ?>
        <h3>Data Seluruh Pengguna</h3>
        <table>
            <tr>
                <th>Nama</th>
                <th>Username</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Fakultas</th>
                <th>Angkatan</th>
            </tr>
            <?php foreach ($users as $u): ?>
            <tr>
                <td><?= htmlspecialchars($u['name'] ?? '-') ?></td>
                <td><?= htmlspecialchars($u['username']) ?></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
                <td><?= htmlspecialchars($u['gender'] ?? '-') ?></td>
                <td><?= htmlspecialchars($u['faculty'] ?? '-') ?></td>
                <td><?= htmlspecialchars($u['batch'] ?? '-') ?></td>
            </tr>
            <?php endforeach; ?>
        </table>

    <?php else: ?>
        <h3>Data Profil Anda</h3>
        <table>
            <tr><th>Nama</th><td><?= htmlspecialchars($user['name'] ?? '-') ?></td></tr>
            <tr><th>Username</th><td><?= htmlspecialchars($user['username']) ?></td></tr>
            <tr><th>Email</th><td><?= htmlspecialchars($user['email']) ?></td></tr>
            <tr><th>Gender</th><td><?= htmlspecialchars($user['gender'] ?? '-') ?></td></tr>
            <tr><th>Fakultas</th><td><?= htmlspecialchars($user['faculty'] ?? '-') ?></td></tr>
            <tr><th>Angkatan</th><td><?= htmlspecialchars($user['batch'] ?? '-') ?></td></tr>
        </table>
    <?php endif; ?>
</div>
</body>
</html>
