<?php   
session_start();
require 'koneksi.php';

// ==================================
// CEK AKSES MEMBER
// ==================================
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'MEMBER') {
    die("Akses ditolak");
}

$id_member = $_SESSION['user']['id'];

// ==================================
// DAFTAR TUGAS YANG DITUGASKAN
// ==================================
$sql = "SELECT t.id, t.nama_tugas, t.status, p.nama_proyek 
        FROM tasks t
        JOIN projects p ON t.project_id = p.id
        WHERE t.assigned_to = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_member);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$tasks = [];
while ($row = mysqli_fetch_assoc($result)) {
    $tasks[] = $row;
}
mysqli_stmt_close($stmt);

// ==================================
// CEK MANAGER DARI MEMBER
// ==================================
$sql = "SELECT project_manager_id FROM users WHERE id=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_member);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $manager_id);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// ==================================
// AMBIL DAFTAR PROYEK DARI MANAGER
// ==================================
$projects = [];
if ($manager_id) {
    $sql = "SELECT p.id, p.nama_proyek, p.deskripsi, p.tanggal_mulai, p.tanggal_selesai, u.username AS nama_manager
            FROM projects p
            JOIN users u ON p.manager_id = u.id
            WHERE p.manager_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $manager_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $projects[] = $row;
    }
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Member</title>
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

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background: #c82333;
        }

        .btn-info {
            background: #17a2b8;
            color: white;
        }

        .btn-info:hover {
            background: #138496;
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

        .tasks-grid {
            display: grid;
            gap: 20px;
        }

        .task-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .task-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }

        .task-info h3 {
            font-size: 18px;
            color: #333;
            margin-bottom: 5px;
        }

        .task-info p {
            font-size: 14px;
            color: #666;
        }

        .task-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        .badge-belum {
            background: #f8d7da;
            color: #721c24;
        }

        .badge-proses {
            background: #fff3cd;
            color: #856404;
        }

        .badge-selesai {
            background: #d4edda;
            color: #155724;
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

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #666;
            font-size: 16px;
        }

        @media (max-width: 768px) {
            .navbar-content {
                flex-direction: column;
                text-align: center;
            }

            .task-card {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .task-actions {
                flex-direction: column;
                width: 100%;
            }

            .btn {
                width: 100%;
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
            <h1>Dashboard Team Member</h1>
            <div>
                <a href="logout.php" class="btn btn-danger" onclick="return confirm('Anda yakin ingin logout?')">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">

        <!-- DAFTAR TUGAS -->
        <section class="section">
            <h2 class="section-title">Daftar Tugas</h2>

            <?php if (empty($tasks)) : ?>
                <div class="card">
                    <div class="empty-state">Belum ada tugas yang ditugaskan</div>
                </div>
            <?php else : ?>
                <div class="tasks-grid">
                    <?php foreach ($tasks as $tugas) : ?>
                        <div class="task-card">
                            <div class="task-info">
                                <h3><?= htmlspecialchars($tugas['nama_tugas']) ?></h3>
                                <p><?= htmlspecialchars($tugas['nama_proyek']) ?></p>
                            </div>

                            <div class="task-actions">
                                <?php
                                    $badge_class = '';
                                    if ($tugas['status'] === 'belum') {
                                        $badge_class = 'badge-belum';
                                    } elseif ($tugas['status'] === 'proses') {
                                        $badge_class = 'badge-proses';
                                    } elseif ($tugas['status'] === 'selesai') {
                                        $badge_class = 'badge-selesai';
                                    }
                                ?>
                                <span class="badge <?= $badge_class ?>">
                                    <?= ucfirst($tugas['status']) ?>
                                </span>

                                <a href="crud_tugas.php?id=<?= $tugas['id'] ?>" 
                                   class="btn btn-info">
                                    Ubah Status
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

        <!-- DAFTAR PROYEK -->
        <section class="section">
            <h2 class="section-title">Daftar Proyek</h2>

            <?php if (empty($projects)) : ?>
                <div class="card">
                    <div class="empty-state">Belum ada proyek yang terdaftar</div>
                </div>
            <?php else : ?>
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
                                        <td><?= htmlspecialchars($p['nama_manager']) ?></td>
                                        <td><?= htmlspecialchars($p['tanggal_mulai']) ?></td>
                                        <td><?= htmlspecialchars($p['tanggal_selesai']) ?></td>
                                        <td>-</td>
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
