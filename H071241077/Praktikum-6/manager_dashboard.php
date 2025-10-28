<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'MANAGER') {
    die("Akses ditolak");
}

$manager_id = $_SESSION['user']['id'];

// =========================
// Hitung total proyek
// =========================
$sql = "SELECT COUNT(*) as total_proyek FROM projects WHERE manager_id=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $manager_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$total_proyek = mysqli_fetch_assoc($result)['total_proyek'] ?? 0;

// =========================
// Hitung total tugas
// =========================
$sql = "SELECT COUNT(*) as total_tugas FROM tasks t
        JOIN projects p ON t.project_id = p.id
        WHERE p.manager_id=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $manager_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$total_tugas = mysqli_fetch_assoc($result)['total_tugas'] ?? 0;

// =========================
// Hitung status tugas
// =========================
$status = ['belum' => 0, 'proses' => 0, 'selesai' => 0];

$sql = "SELECT status, COUNT(*) as jumlah 
        FROM tasks t 
        JOIN projects p ON t.project_id = p.id
        WHERE p.manager_id=? 
        GROUP BY status";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $manager_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

while ($row = mysqli_fetch_assoc($result)) {
    $status[$row['status']] = $row['jumlah'];
}

// =========================
// Ambil daftar proyek
// =========================
$sql = "SELECT * FROM projects WHERE manager_id=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $manager_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$projects = [];
while ($p = mysqli_fetch_assoc($result)) {
    $projects[] = $p;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Manager</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            min-height: 100vh;
        }

        .navbar {
            background: linear-gradient(to right, #8B6F47, #A0826D);
            padding: 20px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .navbar h1 {
            color: white;
            font-size: 24px;
            font-weight: bold;
        }

        .navbar-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            border: none;
            transition: all 0.3s;
            display: inline-block;
        }

        .btn-primary {
            background: white;
            color: #8B6F47;
        }

        .btn-primary:hover {
            background: #f0f0f0;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background: #c82333;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        .section {
            margin-bottom: 40px;
        }

        .section-title {
            font-size: 22px;
            font-weight: bold;
            color: #8B6F47;
            margin-bottom: 20px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-left: 4px solid #8B6F47;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }

        .stat-card h3 {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
            font-weight: 500;
        }

        .stat-card .number {
            font-size: 32px;
            font-weight: bold;
            color: #8B6F47;
        }

        .stat-card .details {
            font-size: 13px;
            color: #666;
            margin-top: 10px;
        }

        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #8B6F47;
        }

        thead th {
            padding: 15px;
            text-align: left;
            font-size: 12px;
            font-weight: 600;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        tbody tr {
            border-bottom: 1px solid #e0e0e0;
            transition: background 0.2s;
        }

        tbody tr:hover {
            background: #f8f8f8;
        }

        tbody td {
            padding: 15px;
            color: #333;
        }

        .btn-sm {
            padding: 6px 14px;
            font-size: 13px;
            border-radius: 6px;
            margin: 2px;
        }

        .btn-warning {
            background: #ffc107;
            color: #000;
        }

        .btn-warning:hover {
            background: #e0a800;
        }

        .btn-delete {
            background: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background: #c82333;
        }

        .btn-info {
            background: #17a2b8;
            color: white;
        }

        .btn-info:hover {
            background: #138496;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #666;
        }

        @media (max-width: 768px) {
            .navbar-content {
                flex-direction: column;
                text-align: center;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            table {
                font-size: 13px;
            }

            thead th, tbody td {
                padding: 10px 8px;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar">
        <div class="navbar-content">
            <h1>Dashboard Project manager</h1>
            <div class="navbar-buttons">
                <a href="crud_proyek.php" class="btn btn-primary">+ Tambah Proyek</a>
                <a href="crud_tugas.php" class="btn btn-primary">Tugas</a>
                <a href="logout.php" class="btn btn-danger" onclick="return confirm('Anda yakin ingin logout?')">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">

        <section class="section">
            <h2 class="section-title">Ringkasan</h2>

            <div class="stats-grid">
                <div class="stat-card">
                    <h3>JUMLAH PROYEK</h3>
                    <div class="number"><?= $total_proyek ?></div>
                </div>

                <div class="stat-card">
                    <h3>JUMLAH TUGAS</h3>
                    <div class="number"><?= $total_tugas ?></div>
                </div>

                <div class="stat-card">
                    <h3>TUGAS SELESAI</h3>
                    <div class="number"><?= $status['selesai'] ?></div>
                    <div class="details">
                        Belum: <?= $status['belum'] ?> | Proses: <?= $status['proses'] ?>
                    </div>
                </div>
            </div>
        </section>

        <section class="section">
            <h2 class="section-title">Daftar Proyek</h2>

            <?php if (count($projects) === 0): ?>
                <div class="card">
                    <div class="empty-state">Belum ada proyek</div>
                </div>
            <?php else: ?>
                <div class="card">
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Proyek</th>
                                    <th>Manager</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php 
                                $no = 1;
                                foreach ($projects as $p): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><strong><?= htmlspecialchars($p['nama_proyek']) ?></strong></td>
                                        <td><?= htmlspecialchars($_SESSION['user']['username']) ?></td>
                                        <td><?= htmlspecialchars($p['tanggal_mulai']) ?></td>
                                        <td><?= htmlspecialchars($p['tanggal_selesai']) ?></td>
                                        <td style="white-space: nowrap;">
                                            <a href="crud_proyek.php?edit_id=<?= $p['id'] ?>"
                                                class="btn btn-sm btn-warning">
                                                Edit
                                            </a>
                                            <a href="crud_proyek.php?hapus_id=<?= $p['id'] ?>"
                                                onclick="return confirm('Yakin ingin menghapus proyek ini?')"
                                                class="btn btn-sm btn-delete">
                                                Hapus
                                            </a>
                                            <a href="crud_tugas.php?project_id=<?= $p['id'] ?>"
                                                class="btn btn-sm btn-info">
                                                Tugas
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        </section>

    </div>
</body>
</html>