<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'ADMIN') {
    die("Akses ditolak");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
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
        }

        .navbar h1 {
            color: white;
            font-size: 24px;
            font-weight: bold;
        }

        .navbar-buttons {
            display: flex;
            gap: 10px;
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
            font-size: 24px;
            font-weight: bold;
            color: #8B6F47;
            margin-bottom: 20px;
        }

        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            overflow: hidden;
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

        .badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-manager {
            background: #d4edda;
            color: #155724;
        }

        .badge-member {
            background: #fff3cd;
            color: #856404;
        }

        .btn-sm {
            padding: 6px 16px;
            font-size: 13px;
            border-radius: 6px;
        }

        .btn-delete {
            background: #dc3545;
            color: white;
            border: none;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn-delete:hover {
            background: #c82333;
        }

        @media (max-width: 768px) {
            .navbar-content {
                flex-direction: column;
                gap: 15px;
            }

            table {
                font-size: 14px;
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
            <h1>Dashboard Super admin</h1>
            <div class="navbar-buttons">
                <a href="user.php" class="btn btn-primary">Kelola User</a>
                <a href="logout.php" class="btn btn-danger" onclick="return confirm('Anda yakin ingin logout?')">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">

        <!-- DAFTAR USER -->
        <section class="section">
            <h2 class="section-title">Daftar Semua User</h2>
            <div class="card">
                <table>
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $user_result = mysqli_query($conn, "SELECT id, username, role FROM users");
                        while ($user = mysqli_fetch_assoc($user_result)) {
                            if ($user['id'] == $_SESSION['user']['id']) continue;

                            $role_color = match($user['role']) {
                                'MANAGER' => 'badge-manager',
                                'MEMBER' => 'badge-member',
                                default => ''
                            };
                        ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($user['username']) ?></strong></td>
                            <td>
                                <span class="badge <?= $role_color ?>"><?= htmlspecialchars($user['role']) ?></span>
                            </td>
                            <td>
                                <a href="user.php?action=delete&id=<?= $user['id'] ?>"
                                    onclick="return confirm('Yakin ingin menghapus user ini?')"
                                    class="btn btn-sm btn-delete">
                                    Hapus
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- DAFTAR PROYEK -->
        <section class="section">
            <h2 class="section-title">Daftar Semua Proyek</h2>
            <div class="card">
                <table>
                    <thead>
                        <tr>
                            <th>Nama Proyek</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Manager</th>
                            <th>Member</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $project_result = mysqli_query($conn, "
                            SELECT p.*, u.username AS manager 
                            FROM projects p 
                            LEFT JOIN users u ON p.manager_id = u.id
                        ");
                        
                        while ($row = mysqli_fetch_assoc($project_result)) {
                            $members = [];
                            $member_result = mysqli_query($conn, "
                                SELECT username 
                                FROM users 
                                WHERE project_manager_id={$row['manager_id']} 
                                AND role='MEMBER'
                            ");
                            while ($m = mysqli_fetch_assoc($member_result)) {
                                $members[] = $m['username'];
                            }
                            $members_str = implode(', ', $members);
                        ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($row['nama_proyek']) ?></strong></td>
                            <td><?= htmlspecialchars($row['tanggal_mulai']) ?></td>
                            <td><?= htmlspecialchars($row['tanggal_selesai']) ?></td>
                            <td><?= htmlspecialchars($row['manager']) ?></td>
                            <td><?= htmlspecialchars($members_str) ?></td>
                            <td>
                                <a href="crud_proyek.php?hapus_id=<?= $row['id'] ?>"
                                   onclick="return confirm('Yakin ingin menghapus proyek ini?')"
                                   class="btn btn-sm btn-delete">
                                   Hapus
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>

    </div>
</body>
</html>