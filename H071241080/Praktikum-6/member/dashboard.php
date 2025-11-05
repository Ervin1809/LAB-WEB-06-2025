<?php
include('../config/auth.php');
checkRole(['Team Member']); 
$member_id = $_SESSION['user_id'];
?>

<?php
$message = "";

if (isset($_POST['update_status'])) {
    $task_id = $conn->real_escape_string($_POST['task_id']);
    $new_status = $conn->real_escape_string($_POST['new_status']);

    $sql_update = "UPDATE tasks SET status = ? WHERE id = ? AND assigned_to = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("sii", $new_status, $task_id, $member_id);
    
    if ($stmt->execute()) {
        $message = "<div class='alert alert-success'>Status tugas berhasil diubah menjadi " . ucfirst($new_status) . "</div>";
    } else {
        $message = "<div class='alert alert-danger'>Gagal mengupdate status.</div>";
    }
    $stmt->close();
}

$sql_tasks = "SELECT 
                 t.id AS task_id, 
                 t.nama_tugas, 
                 t.deskripsi,
                 t.status,
                 p.nama_proyek,
                 pm.username AS project_manager_name
               FROM tasks t
               JOIN projects p ON t.project_id = p.id
               JOIN users pm ON p.manager_id = pm.id
               WHERE t.assigned_to = '$member_id'
               ORDER BY 
                 CASE t.status 
                   WHEN 'belum' THEN 1 
                   WHEN 'proses' THEN 2 
                   WHEN 'selesai' THEN 3 
                   ELSE 4 
                 END ASC, 
                 p.tanggal_mulai DESC"; 

$tasks_result = $conn->query($sql_tasks);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Team Member</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css"> 
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
            <h2 class="text-primary">Selamat Datang, <?php echo $_SESSION['username']; ?></h2>
            <a href="../logout.php" class="btn btn-danger">Logout</a>
        </div>
        
        <p class="text-muted">Hak akses Anda: Dapat melihat dan mengubah status tugas yang ditugaskan kepada Anda.</p>

        <h3 class="mt-4 mb-3">Daftar Tugas Anda</h3>
        
        <?php echo $message; ?>

        <?php if ($tasks_result->num_rows > 0): ?>
            <div class="row">
                <?php while ($row = $tasks_result->fetch_assoc()): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm task-card 
                            <?php 
                                
                                if ($row['status'] == 'selesai') echo 'status-selesai';
                                elseif ($row['status'] == 'proses') echo 'status-proses';
                                else echo 'status-belum';
                            ?>">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0"><?php echo htmlspecialchars($row['nama_tugas']); ?></h5>
                                <small class="text-muted">Proyek: <?php echo htmlspecialchars($row['nama_proyek']); ?> (Project Manager: <?php echo htmlspecialchars($row['project_manager_name']); ?>)</small>
                            </div>
                            <div class="card-body">
                                <p class="card-text"><?php echo htmlspecialchars($row['deskripsi']); ?></p>
                                <hr>
                                
                                <form method="POST" action="dashboard.php" class="form-inline d-flex justify-content-between align-items-center">
                                    <input type="hidden" name="task_id" value="<?php echo $row['task_id']; ?>">
                                    
                                    <label for="status-<?php echo $row['task_id']; ?>" class="mr-2 mb-0">Status: <?php echo ucfirst($row['status']); ?></label>
                                    
                                    <div>
                                        <select class="form-control form-control-sm mr-2" id="status-<?php echo $row['task_id']; ?>" name="new_status" required>
                                            <option value="belum" <?php echo ($row['status'] == 'belum') ? 'selected' : ''; ?>>Belum</option>
                                            <option value="proses" <?php echo ($row['status'] == 'proses') ? 'selected' : ''; ?>>Proses</option>
                                            <option value="selesai" <?php echo ($row['status'] == 'selesai') ? 'selected' : ''; ?>>Selesai</option>
                                        </select>
                                        
                                        <button type="submit" name="update_status" class="btn btn-sm btn-primary">Ubah</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info" role="alert">
                Anda belum ditugaskan ke proyek atau tugas apapun.
            </div>
        <?php endif; ?>

    </div>
</body>
</html>