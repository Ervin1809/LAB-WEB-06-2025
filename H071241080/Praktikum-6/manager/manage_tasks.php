<?php
include('../config/auth.php');
checkRole(['Project Manager']); 
$manager_id = $_SESSION['user_id']; 
?>

<?php
$project_id = null;
$project_name = "Proyek Tidak Dikenal";
$message = "";

if (isset($_GET['project_id'])) {
    $project_id = $conn->real_escape_string($_GET['project_id']);

    $sql_project = "SELECT nama_proyek FROM projects WHERE id = '$project_id' AND manager_id = '$manager_id'";
    $result_project = $conn->query($sql_project);

    if ($result_project->num_rows == 1) {
        $project_name = $result_project->fetch_assoc()['nama_proyek'];
    } else {
        header("Location: manage_projects.php");
        exit;
    }
} else {
    header("Location: manage_projects.php");
    exit;
}

if (isset($_GET['delete_task_id'])) {
    $delete_task_id = $conn->real_escape_string($_GET['delete_task_id']);
    
    $sql_delete = "DELETE FROM tasks WHERE id = '$delete_task_id' AND project_id = '$project_id'";
    
    if ($conn->query($sql_delete) === TRUE) {
        header("Location: manage_tasks.php?project_id={$project_id}&status=deleted");
        exit;
    } else {
        $message = "<div class='alert alert-danger'>Error menghapus tugas.</div>";
    }
}

if (isset($_GET['status']) && $_GET['status'] == 'deleted') {
    $message = "<div class='alert alert-success'>Tugas berhasil dihapus.</div>";
}

if (isset($_GET['status'])) {
    if ($_GET['status'] == 'added') {
        $message = "<div class='alert alert-success'>Tugas baru berhasil ditambahkan.</div>";
    } elseif ($_GET['status'] == 'updated') {
        $message = "<div class='alert alert-success'>Tugas berhasil diupdate.</div>";
    }
}

$sql_tasks = "SELECT 
                 t.id, 
                 t.nama_tugas, 
                 t.status, 
                 u.username AS assigned_to_user 
                FROM tasks t
                LEFT JOIN users u ON t.assigned_to = u.id
                WHERE t.project_id = '$project_id'
                ORDER BY 
                  CASE t.status 
                    WHEN 'belum' THEN 1 
                    WHEN 'proses' THEN 2 
                    WHEN 'selesai' THEN 3 
                    ELSE 4 
                  END ASC, 
                  t.id DESC"; 

$tasks_result = $conn->query($sql_tasks);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Tugas - <?php echo htmlspecialchars($project_name); ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container mt-5">
        
        <div class="d-flex justify-content-between align-items-start mb-4 pb-2 border-bottom">
            
            <h3 class="text-primary mr-3 flex-grow-1">
                Kelola Tugas Proyek: <strong style="word-break: break-word;"><?php echo htmlspecialchars($project_name); ?></strong>
            </h3>
            
            <div class="btn-group-vertical btn-group-sm flex-shrink-0" role="group">
                <a href="manage_projects.php" class="btn btn-secondary mb-1">Kembali ke Proyek</a>
                <a href="task_form.php?project_id=<?php echo $project_id; ?>" class="btn btn-primary">➕ Tambah Tugas Baru</a>
            </div>
        </div>
        <?php echo $message; ?>

        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped shadow-sm">
                <thead class="thead-dark">
                    <tr>
                        <th style="width: 50px;">ID</th>
                        <th>Nama Tugas</th>
                        <th style="width: 200px;">Ditugaskan Kepada</th>
                        <th style="width: 100px;">Status</th>
                        <th style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($tasks_result->num_rows > 0): ?>
                        <?php while ($row = $tasks_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['nama_tugas']); ?></td>
                                <td><?php echo htmlspecialchars($row['assigned_to_user']); ?></td>
                                <td>
                                    <span class="badge 
                                        <?php 
                                            if ($row['status'] == 'selesai') echo 'badge-success';
                                            elseif ($row['status'] == 'proses') echo 'badge-warning';
                                            else echo 'badge-danger';
                                        ?>">
                                        <?php echo ucfirst($row['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="task_form.php?edit_task_id=<?php echo $row['id']; ?>&project_id=<?php echo $project_id; ?>" class="btn btn-warning btn-sm mb-1">Edit</a>
                                    <a href="manage_tasks.php?delete_task_id=<?php echo $row['id']; ?>&project_id=<?php echo $project_id; ?>" 
                                        class="btn btn-danger btn-sm mb-1" 
                                        onclick="return confirm('Yakin ingin menghapus tugas <?php echo htmlspecialchars($row['nama_tugas']); ?>?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-4">Belum ada tugas dalam proyek ini.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</body>
</html>