<?php
include('../config/auth.php');
checkRole(['Super Admin']); 
$superadmin_id = $_SESSION['user_id'];
?>

<?php
$message = "";

if (isset($_GET['status'])) {
    if ($_GET['status'] == 'deleted') {
        $message = "<div class='alert alert-success'>Proyek dan semua tugas terkait berhasil dihapus.</div>";
    }
}

if (isset($_GET['delete_id'])) {
    $delete_id = $conn->real_escape_string($_GET['delete_id']);
    
    $conn->begin_transaction();
    $delete_success = false;

    try {
        $conn->query("DELETE FROM tasks WHERE project_id = '$delete_id'");
        $conn->query("DELETE FROM projects WHERE id = '$delete_id'");
        
        $conn->commit();
        $delete_success = true;
    } catch (Exception $e) {
        $conn->rollback();
        $message = "<div class='alert alert-danger'>Error menghapus proyek: " . $e->getMessage() . "</div>";
    }

    if ($delete_success) {
        header("Location: manage_projects_global.php?status=deleted");
        exit;
    }
}

$sql = "SELECT 
            p.id, 
            p.nama_proyek, 
            p.deskripsi, 
            p.tanggal_mulai, 
            p.tanggal_selesai,
            u.username AS manager_name,
            COUNT(t.id) AS jumlah_tugas
        FROM projects p
        LEFT JOIN users u ON p.manager_id = u.id
        LEFT JOIN tasks t ON t.project_id = p.id
        GROUP BY p.id, u.username
        ORDER BY p.tanggal_mulai DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Proyek Global (Super Admin)</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <h3 class="text-primary">🌎 Daftar Seluruh Proyek (Global View)</h3>
        <div>
            <a href="dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
        </div>
    </div>

    <?php echo $message; ?>

    <div class="table-responsive shadow-sm">
        <table class="table table-hover table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nama Proyek</th>
                    <th>Manager</th>
                    <th>Mulai</th>
                    <th>Selesai</th>
                    <th>Tugas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td>
                                <strong><?php echo htmlspecialchars($row['nama_proyek']); ?></strong>
                                <small class="d-block text-muted"><?php echo substr(htmlspecialchars($row['deskripsi']), 0, 50) . (strlen($row['deskripsi']) > 50 ? '...' : ''); ?></small>
                            </td>
                            <td><?php echo htmlspecialchars($row['manager_name'] ?? 'N/A'); ?></td>
                            <td><?php echo date('d M Y', strtotime($row['tanggal_mulai'])); ?></td>
                            <td><?php echo date('d M Y', strtotime($row['tanggal_selesai'])); ?></td>
                            <td><span class="badge badge-info"><?php echo $row['jumlah_tugas']; ?></span></td>
                            <td>
                                <a href="view_project_detail.php?id=<?php echo $row['id']; ?>" 
                                   class="btn btn-info btn-sm mb-1">
                                    👁️ Detail
                                </a>
                                <a href="edit_project_global.php?id=<?php echo $row['id']; ?>" 
                                   class="btn btn-warning btn-sm mb-1">✏️ Edit
                                </a>
                                <a href="manage_projects_global.php?delete_id=<?php echo $row['id']; ?>" 
                                   class="btn btn-danger btn-sm mb-1"
                                   onclick="return confirm('Yakin ingin menghapus proyek <?php echo htmlspecialchars($row['nama_proyek']); ?> beserta semua tugasnya? Tindakan ini tidak dapat dibatalkan.')">
                                    🗑️ Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="7" class="text-center py-4">Belum ada proyek yang terdaftar di sistem.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>