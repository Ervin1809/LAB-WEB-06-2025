<?php
session_start();
require_once 'data.php';

// Perlindungan halaman - jika belum login, redirect ke login
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$currentUser = $_SESSION['user'];
$isAdmin = ($currentUser['username'] === 'adminxxx');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Login Sederhana</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            margin-bottom: 10px;
        }

        .logout-link {
            display: inline-block;
            color: #dc3545;
            text-decoration: none;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .logout-link:hover {
            text-decoration: underline;
        }

        h2 {
            color: #333;
            margin-top: 20px;
            margin-bottom: 15px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th {
            background-color: #f8f9fa;
            color: #333;
            font-weight: 600;
            text-align: left;
            padding: 12px;
            border: 1px solid #dee2e6;
        }

        td {
            padding: 12px;
            border: 1px solid #dee2e6;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        tr:hover {
            background-color: #e9ecef;
        }

        .data-label {
            background-color: #f8f9fa;
            font-weight: 600;
            width: 150px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($isAdmin): ?>
            <!-- Tampilan untuk Admin -->
            <h1>Selamat Datang, Admin!</h1>
            <a href="logout.php" class="logout-link">Logout</a>

            <h2>Data Semua Pengguna</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>Fakultas</th>
                        <th>Angkatan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['name']); ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo isset($user['gender']) ? htmlspecialchars($user['gender']) : '-'; ?></td>
                            <td><?php echo isset($user['faculty']) ? htmlspecialchars($user['faculty']) : '-'; ?></td>
                            <td><?php echo isset($user['batch']) ? htmlspecialchars($user['batch']) : '-'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php else: ?>
            <!-- Tampilan untuk User Biasa -->
            <h1>Selamat Datang, <?php echo htmlspecialchars($currentUser['name']); ?>!</h1>
            <a href="logout.php" class="logout-link">Logout</a>

            <h2>Data Anda</h2>
            <table>
                <tr>
                    <td class="data-label">Nama</td>
                    <td><?php echo htmlspecialchars($currentUser['name']); ?></td>
                </tr>
                <tr>
                    <td class="data-label">Username</td>
                    <td><?php echo htmlspecialchars($currentUser['username']); ?></td>
                </tr>
                <tr>
                    <td class="data-label">Email</td>
                    <td><?php echo htmlspecialchars($currentUser['email']); ?></td>
                </tr>
                <?php if (isset($currentUser['gender'])): ?>
                <tr>
                    <td class="data-label">Gender</td>
                    <td><?php echo htmlspecialchars($currentUser['gender']); ?></td>
                </tr>
                <?php endif; ?>
                <?php if (isset($currentUser['faculty'])): ?>
                <tr>
                    <td class="data-label">Fakultas</td>
                    <td><?php echo htmlspecialchars($currentUser['faculty']); ?></td>
                </tr>
                <?php endif; ?>
                <?php if (isset($currentUser['batch'])): ?>
                <tr>
                    <td class="data-label">Angkatan</td>
                    <td><?php echo htmlspecialchars($currentUser['batch']); ?></td>
                </tr>
                <?php endif; ?>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>