<?php
session_start();

include 'data.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$current_user = $_SESSION['user']; 

$is_admin = ($current_user['username'] === 'adminxxx');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            padding: 30px; 
            background-color: #e9ecef;
        }
        .container { 
            max-width: 1000px; 
            margin: 0 auto; 
            background-color: #ffffff; 
            padding: 30px; 
            border-radius: 12px; 
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05); 
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center; 
            border-bottom: 2px solid #ced4da;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header-section h1 { 
            color: #212529;
            margin: 0; 
            padding: 0;
            border-bottom: none; 
            font-weight: 300;
            font-size: 2em; 
        }
        
        h2 {
            color: #495057;
            margin-top: 30px;
            font-weight: 600;
        }
        
        .logout-link a { 
            background-color: #dc3545;
            color: white; 
            padding: 8px 16px; 
            border-radius: 5px; 
            text-decoration: none; 
            font-size: 14px;
            font-weight: 600;
            transition: background-color 0.3s;
        }
        .logout-link a:hover { 
            background-color: #c82333;
            text-decoration: none; 
        }
        
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px; 
        }
        th, td { 
            border: 1px solid #e9ecef; 
            padding: 12px; 
            text-align: left; 
        }
        th { 
            background-color: #f8f9fa; 
            color: #343a40;
            width: 150px; 
        }
        
        .admin-table th {
            background-color: #212529; 
            color: white;
            border-color: #343a40;
        }
        .admin-table tr:nth-child(even) {
            background-color: #fcfcfc;
        }
    </style>
</head>
<body>

<div class="container">

    <div class="header-section">
        <h1>Selamat Datang, <?php echo htmlspecialchars($current_user['name']); ?>!</h1>
        
        <p class="logout-link"><a href="logout.php">Logout</a></p>
    </div>

    <h2>Data <?php echo $is_admin ? 'Semua Pengguna' : 'Anda'; ?></h2>
    
    <?php if ($is_admin): ?>
        
        <table class="admin-table">
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
                        <td><?php echo htmlspecialchars($user['gender'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($user['faculty'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($user['batch'] ?? 'N/A'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php else: ?>
    
        <table>
            <tr>
                <th>Nama</th>
                <td><?php echo htmlspecialchars($current_user['name']); ?></td>
            </tr>
            <tr>
                <th>Username</th>
                <td><?php echo htmlspecialchars($current_user['username']); ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo htmlspecialchars($current_user['email']); ?></td>
            </tr>
            <tr>
                <th>Gender</th>
                <td><?php echo htmlspecialchars($current_user['gender'] ?? 'N/A'); ?></td>
            </tr>
            <tr>
                <th>Fakultas</th>
                <td><?php echo htmlspecialchars($current_user['faculty'] ?? 'N/A'); ?></td>
            </tr>
            <tr>
                <th>Angkatan</th>
                <td><?php echo htmlspecialchars($current_user['batch'] ?? 'N/A'); ?></td>
            </tr>
        </table>
        
    <?php endif; ?>

</div>

</body>
</html>
