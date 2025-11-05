<?php
include('../config/auth.php');
checkRole(['Super Admin']); 
$superadmin_id = $_SESSION['user_id'];
?>

<?php
$project_id = null;
$message = "";

if (!isset($_GET['id'])) {
    header("Location: manage_projects_global.php");
    exit;
}
$project_id = $conn->real_escape_string($_GET['id']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_proyek = $conn->real_escape_string($_POST['nama_proyek']);
    $deskripsi = $conn->real_escape_string($_POST['deskripsi']);
    $tanggal_mulai = $conn->real_escape_string($_POST['tanggal_mulai']);
    $tanggal_selesai = $conn->real_escape_string($_POST['tanggal_selesai']);
    $new_manager_id = $conn->real_escape_string($_POST['manager_id']);

    if (strtotime($tanggal_selesai) < strtotime($tanggal_mulai)) {
        $message = "<div class='alert alert-danger'>Gagal memperbarui! Target Selesai tidak boleh lebih awal dari Tanggal Mulai.</div>";
    }

    if (empty($message)) {
        $sql_update = "UPDATE projects SET 
                       nama_proyek = ?,
                       deskripsi = ?,
                       tanggal_mulai = ?,
                       tanggal_selesai = ?,
                       manager_id = ?
                       WHERE id = ?";

        $stmt = $conn->prepare($sql_update);
        $stmt->bind_param("ssssii", $nama_proyek, $deskripsi, $tanggal_mulai, $tanggal_selesai, $new_manager_id, $project_id);
        
        if ($stmt->execute()) {
            $message = "<div class='alert alert-success'>Proyek " . htmlspecialchars($nama_proyek) . " berhasil diperbarui!</div>";
        } else {
            $message = "<div class='alert alert-danger'>Gagal memperbarui proyek: " . $conn->error . "</div>";
        }
        $stmt->close();
    }
}

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

if (!empty($message) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $project['nama_proyek'] = $_POST['nama_proyek'];
    $project['deskripsi'] = $_POST['deskripsi'];
    $project['tanggal_mulai'] = $_POST['tanggal_mulai'];
    $project['tanggal_selesai'] = $_POST['tanggal_selesai'];
    $project['manager_id'] = $_POST['manager_id'];
    
    $selected_manager_id = $_POST['manager_id'];
    $sql_manager_name = "SELECT username FROM users WHERE id = '$selected_manager_id'";
    $result_manager_name = $conn->query($sql_manager_name);
    if($result_manager_name && $result_manager_name->num_rows > 0) {
        $project['manager_name'] = $result_manager_name->fetch_assoc()['username'];
    }
}

$sql_managers = "SELECT id, username FROM users WHERE role = 'Project Manager' ORDER BY username";
$managers_result = $conn->query($sql_managers);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Proyek Global - <?php echo htmlspecialchars($project['nama_proyek']); ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <h3 class="text-primary">Edit Proyek: <?php echo htmlspecialchars($project['nama_proyek']); ?></h3>
        <a href="manage_projects_global.php" class="btn btn-secondary">Batal & Kembali</a>
    </div>

    <?php echo $message; ?>

    <div class="card p-4 shadow-sm border-0">
        <form method="POST" action="edit_project_global.php?id=<?php echo $project_id; ?>">
            <div class="form-group">
                <label for="nama_proyek">Nama Proyek</label>
                <input type="text" class="form-control" id="nama_proyek" name="nama_proyek" 
                       value="<?php echo htmlspecialchars($project['nama_proyek']); ?>" required>
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required><?php echo htmlspecialchars($project['deskripsi']); ?></textarea>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="tanggal_mulai">Tanggal Mulai</label>
                    <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" 
                           value="<?php echo htmlspecialchars($project['tanggal_mulai']); ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="tanggal_selesai">Target Selesai</label>
                    <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" 
                           value="<?php echo htmlspecialchars($project['tanggal_selesai']); ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label for="manager_id">Ganti Manajer yang Bertanggung Jawab</label>
                <select class="form-control" id="manager_id" name="manager_id" required>
                    <option value="">-- Pilih Manajer Baru (Saat Ini: <?php echo htmlspecialchars($project['manager_name'] ?? 'N/A'); ?>) --</option>
                    <?php mysqli_data_seek($managers_result, 0); 
                    while ($manager = $managers_result->fetch_assoc()): ?>
                        <option value="<?php echo $manager['id']; ?>" 
                                <?php echo ($project['manager_id'] == $manager['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($manager['username']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                <small class="form-text text-danger">Memilih manajer baru akan segera memindahkan kepemilikan proyek.</small>
            </div>

            <button type="submit" class="btn btn-primary mt-3">💾 Simpan Perubahan Global</button>
        </form>
    </div>
    
</div>
</body>
</html>