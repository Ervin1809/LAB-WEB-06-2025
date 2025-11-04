<?php
include('../config/auth.php');
checkRole(['Project Manager']); 
$manager_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Project Manager</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container mt-5">
        
        <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
            <h2 class="text-primary">Selamat Datang, <?php echo $_SESSION['username']; ?></h2>
            <a href="../logout.php" class="btn btn-danger">Logout</a>
        </div>
        
        <p class="text-muted">Hak akses Anda: Mengelola proyek milik Anda sendiri dan tugas di dalamnya.</p>
        
        <h3 class="mt-4 mb-3">Menu Project Manager</h3>

        <div class="list-group mb-4 shadow-sm">
            <a href="manage_projects.php" class="list-group-item list-group-item-action list-action-primary">
                Kelola Proyek Anda (CRUD Proyek)
            </a>
            </div>
        
    </div>
</body>
</html>