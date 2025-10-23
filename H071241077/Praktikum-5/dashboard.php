<?php
// dashboard.php
session_start();

if (!isset($_SESSION['user'])) {
    $_SESSION['error'] = 'Silakan login terlebih dahulu.';
    header('Location: login.php');
    exit;
}

// Ambil data user saat ini dari session
$currentUser = $_SESSION['user'];

// Include data users (untuk admin yang ingin melihat semua)
require_once __DIR__ . '/data.php';

function e($v) {
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>Dashboard</title>
  <style>
    body {
      font-family: 'Segoe UI', Arial, sans-serif;
      background: linear-gradient(135deg, #e3f2fd, #bbdefb);
      color: #222;
      margin: 0;
      padding: 24px;
    }

    .top {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
      margin-bottom: 20px;
    }

    .card {
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
      transition: 0.3s ease;
    }

    .card:hover {
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }

    h1 {
      margin: 0 0 6px 0;
      font-size: 22px;
      color: #0d47a1;
    }

    h2 {
      color: #1565c0;
      margin-bottom: 12px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 12px;
      font-size: 14px;
      border-radius: 8px;
      overflow: hidden;
    }

    th, td {
      padding: 10px 12px;
      border: 1px solid #e3f2fd;
      text-align: left;
    }

    th {
      background: #bbdefb;
      color: #0d47a1;
      font-weight: bold;
    }

    tr:nth-child(even) {
      background-color: #f7fbff;
    }

    tr:hover {
      background-color: #e3f2fd;
    }

    .logout {
      padding: 8px 12px;
      border-radius: 6px;
      background: #1e88e5;
      color: white;
      text-decoration: none;
      font-weight: 600;
      transition: 0.3s;
    }

    .logout:hover {
      background: #1565c0;
    }

    .small {
      font-size: 13px;
      color: #555;
    }

    .meta {
      margin-top: 10px;
      color: #555;
      font-size: 14px;
    }

    .status-admin {
      color: #0d47a1;
      font-weight: bold;
      background: #bbdefb;
      padding: 3px 8px;
      border-radius: 6px;
      text-align: center;
    }

    .status-user {
      color: #1565c0;
      background: #e3f2fd;
      padding: 3px 8px;
      border-radius: 6px;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="top">
    <div>
      <?php if ($currentUser['username'] === 'adminxxx'): ?>
        <h1>Selamat Datang, Admin!</h1>
        <div class="small">Anda masuk sebagai <strong><?= e($currentUser['username']) ?></strong></div>
      <?php else: ?>
        <h1>Selamat Datang, <?= e($currentUser['name'] ?? $currentUser['username']) ?>!</h1>
        <div class="small">Anda masuk sebagai <strong><?= e($currentUser['username']) ?></strong></div>
      <?php endif; ?>
    </div>

    <div>
      <a class="logout" href="logout.php" onclick="return confirm('Yakin ingin logout?')">Logout</a>
    </div>
  </div>

  <div class="card">
    <?php if ($currentUser['username'] === 'adminxxx'): ?>
      <h2>Data Semua Pengguna</h2>
      <table>
        <thead>
          <tr>
            <th>No</th>
            <th>Username</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Gender</th>
            <th>Fakultas</th>
            <th>Angkatan</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; foreach ($users as $u): ?>
            <?php
              $status = ($u['username'] === 'adminxxx')
                ? '<span class="status-admin">Admin</span>'
                : '<span class="status-user">User</span>';
            ?>
            <tr>
              <td><?= $i++ ?></td>
              <td><?= e($u['username'] ?? '') ?></td>
              <td><?= e($u['name'] ?? '-') ?></td>
              <td><?= e($u['email'] ?? '-') ?></td>
              <td><?= e($u['gender'] ?? '-') ?></td>
              <td><?= e($u['faculty'] ?? '-') ?></td>
              <td><?= e($u['batch'] ?? '-') ?></td>
              <td><?= $status ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <h2>Profil Anda</h2>
      <table>
        <tr><th>Username</th><td><?= e($currentUser['username'] ?? '-') ?></td></tr>
        <tr><th>Nama</th><td><?= e($currentUser['name'] ?? '-') ?></td></tr>
        <tr><th>Email</th><td><?= e($currentUser['email'] ?? '-') ?></td></tr>
        <tr><th>Gender</th><td><?= e($currentUser['gender'] ?? '-') ?></td></tr>
        <tr><th>Fakultas</th><td><?= e($currentUser['faculty'] ?? '-') ?></td></tr>
        <tr><th>Angkatan</th><td><?= e($currentUser['batch'] ?? '-') ?></td></tr>
        <tr><th>Status</th><td><span class="status-user">User</span></td></tr>
      </table>
    <?php endif; ?>

    <div class="meta">
      <p>Halaman ini hanya dapat diakses jika Anda telah login. Jika ingin keluar, gunakan tombol <strong>Logout</strong>.</p>
    </div>
  </div>
</body>
</html>
