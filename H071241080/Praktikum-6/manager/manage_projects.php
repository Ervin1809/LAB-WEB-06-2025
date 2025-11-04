<?php
include('../config/auth.php');
checkRole(['Project Manager']); 
$manager_id = $_SESSION['user_id'];

$message = "";

if (isset($_GET['delete_id'])) {
    $delete_id = $conn->real_escape_string($_GET['delete_id']);

    $sql_delete = "DELETE FROM projects WHERE id = '$delete_id' AND manager_id = '$manager_id'";
    
    if ($conn->query($sql_delete) === TRUE) {
        $message = "<div class='alert alert-success'>Proyek dan semua tugas terkait berhasil dihapus.</div>";
    } else {
        $message = "<div class='alert alert-danger'>Error menghapus proyek atau Anda tidak memiliki izin.</div>";
    }
}

$sql = "SELECT * FROM projects WHERE manager_id = '$manager_id' ORDER BY tanggal_mulai DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Proyek Saya</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
            <h3 class="text-primary">Proyek yang Saya Kelola</h3>
            <div>
                <a href="dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
                <a href="project_form.php" class="btn btn-primary">➕ Tambah Proyek Baru</a>
            </div>
        </div>
        
        <?php echo $message; ?>

        <table class="table table-bordered table-striped shadow-sm">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nama Proyek</th>
                    <th>Periode</th>
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
                                <small class="d-block text-muted"><?php echo substr(htmlspecialchars($row['deskripsi']), 0, 80) . '...'; ?></small>
                            </td>
                            <td><?php echo date('d M Y', strtotime($row['tanggal_mulai'])) . ' s/d ' . date('d M Y', strtotime($row['tanggal_selesai'])); ?></td>
                            <td>
                                <a href="manage_tasks.php?project_id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">Kelola Tugas</a>
                                <a href="project_form.php?edit_id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="manage_projects.php?delete_id=<?php echo $row['id']; ?>" 
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Yakin ingin menghapus proyek ini? Semua tugas akan terhapus.')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">Anda belum membuat proyek. Silakan buat yang baru.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

    </div>
</body>
</html>