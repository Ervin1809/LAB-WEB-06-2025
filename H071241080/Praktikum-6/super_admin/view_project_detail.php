<?php
include('../config/auth.php');
checkRole(['Super Admin']); 
$superadmin_id = $_SESSION['user_id'];
?>

<?php
if (!isset($_GET['id'])) {
    header("Location: manage_projects_global.php");
    exit;
}

$project_id = $conn->real_escape_string($_GET['id']);

$sql_project = "SELECT p.*, u.username AS manager_name 
                FROM projects p 
                LEFT JOIN users u ON p.manager_id = u.id 
                WHERE p.id = '$project_id'";
$project_result = $conn->query($sql_project);
if ($project_result->num_rows === 0) {
    header("Location: manage_projects_global.php");
    exit;
}
$project = $project_result->fetch_assoc();

$sql_tasks = "SELECT t.nama_tugas, t.deskripsi, t.status, m.username AS assigned_to
              FROM tasks t
              LEFT JOIN users m ON t.assigned_to = m.id
              WHERE t.project_id = '$project_id'
              ORDER BY t.status, t.nama_tugas"; 
$tasks = $conn->query($sql_tasks);

function getStatusBadgeClass($status) {
    switch (strtolower($status)) {
        case 'selesai':
            return 'badge-success';
        case 'progress':
            return 'badge-warning';
        case 'todo':
            return 'badge-secondary';
        default:
            return 'badge-light';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Proyek - <?php echo htmlspecialchars($project['nama_proyek']); ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="container mt-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <h2 class="text-primary">👁️ Detail Proyek: <?php echo htmlspecialchars($project['nama_proyek']); ?></h2>
        <div>
            <a href="manage_projects_global.php" class="btn btn-secondary">Batal & Kembali</a>
        </div>
    </div>
    
    <div class="p-4 border rounded shadow-sm bg-white mb-5">
        
        <h4 class="mb-3">Informasi Utama</h4>
        <div class="row">
            <div class="col-md-6 mb-4"> 
                
                <div class="d-flex align-items-center mb-3">
                    <strong style="margin-right: 10px;">Manager Penanggung Jawab:</strong>
                    <span class="badge badge-info p-2"><?php echo htmlspecialchars($project['manager_name'] ?? 'N/A'); ?></span>
                </div>

                <div class="d-flex align-items-center mb-2">
                    <strong style="width: 130px;">Tanggal Mulai:</strong>
                    <span class="badge badge-light p-2 border"><?php echo date('d M Y', strtotime($project['tanggal_mulai'])); ?></span>
                </div>

                <div class="d-flex align-items-center mb-2">
                    <strong style="width: 130px;">Target Selesai:</strong>
                    <span class="badge badge-light p-2 border"><?php echo date('d M Y', strtotime($project['tanggal_selesai'])); ?></span>
                </div>

            </div>
            <div class="col-md-6">
                <strong class="d-block mb-1">Deskripsi:</strong>
                <div class="p-3 border rounded bg-light" style="min-height: 100px;">
                    <?php echo nl2br(htmlspecialchars($project['deskripsi'])); ?>
                </div>
            </div>
        </div>
    </div>

    <h4 class="mb-3">Daftar Tugas dalam Proyek (<?php echo htmlspecialchars($project['nama_proyek']); ?>)</h4>
    <div class="table-responsive shadow-sm">
        <table class="table table-hover table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Nama Tugas</th>
                    <th>Deskripsi Singkat</th>
                    <th>Dikerjakan Oleh</th>
                    <th style="width: 150px;">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($tasks->num_rows > 0): ?>
                    <?php while ($t = $tasks->fetch_assoc()): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($t['nama_tugas']); ?></strong></td>
                            <td><?php echo substr(htmlspecialchars($t['deskripsi']), 0, 80) . (strlen($t['deskripsi']) > 80 ? '...' : ''); ?></td>
                            <td><?php echo htmlspecialchars($t['assigned_to'] ?? 'Belum Ditugaskan'); ?></td>
                            <td>
                                <?php 
                                $status_text = ucfirst($t['status']);
                                $badge_class = getStatusBadgeClass($t['status']);
                                echo "<span class='badge {$badge_class}'>{$status_text}</span>";
                                ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="4" class="text-center py-3">Belum ada tugas yang ditugaskan untuk proyek ini.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>