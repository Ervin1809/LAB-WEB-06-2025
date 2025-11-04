<?php
include('../config/auth.php');
checkRole(['Project Manager']); 
$manager_id = $_SESSION['user_id'];

$project = [
    'nama_proyek' => '', 
    'deskripsi' => '', 
    'tanggal_mulai' => '', 
    'tanggal_selesai' => ''
];
$edit_id = null;
$message = "";

if (isset($_GET['edit_id'])) {
    $edit_id = $conn->real_escape_string($_GET['edit_id']);
    
    $sql_fetch = "SELECT * FROM projects WHERE id = '$edit_id' AND manager_id = '$manager_id'";
    $result_fetch = $conn->query($sql_fetch);
    
    if ($result_fetch->num_rows == 1) {
        $project = $result_fetch->fetch_assoc();
    } else {
        $message = "<div class='alert alert-danger'>Proyek tidak ditemukan atau Anda tidak memiliki izin.</div>";
        $edit_id = null; 
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_proyek = $conn->real_escape_string($_POST['nama_proyek']);
    $deskripsi = $conn->real_escape_string($_POST['deskripsi']);
    $tanggal_mulai = $conn->real_escape_string($_POST['tanggal_mulai']);
    $tanggal_selesai = $conn->real_escape_string($_POST['tanggal_selesai']);
    $project_id = $conn->real_escape_string($_POST['project_id'] ?? '');

    $project['nama_proyek'] = $nama_proyek;
    $project['deskripsi'] = $deskripsi;
    $project['tanggal_mulai'] = $tanggal_mulai;
    $project['tanggal_selesai'] = $tanggal_selesai;
    
    if (strtotime($tanggal_selesai) < strtotime($tanggal_mulai)) {
        $message = "<div class='alert alert-danger'>Gagal menyimpan proyek! Target Selesai (" . date('d M Y', strtotime($tanggal_selesai)) . ") tidak boleh lebih awal dari Tanggal Mulai (" . date('d M Y', strtotime($tanggal_mulai)) . ").</div>";
    }

    if (empty($message)) {
        if (empty($project_id)) {
            $sql = "INSERT INTO projects (nama_proyek, deskripsi, tanggal_mulai, tanggal_selesai, manager_id) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $nama_proyek, $deskripsi, $tanggal_mulai, $tanggal_selesai, $manager_id);
            
            if ($stmt->execute()) {
                header("Location: manage_projects.php?status=created");
                exit;
            } else {
                $message = "<div class='alert alert-danger'>Gagal menambah proyek: " . $conn->error . "</div>";
            }
            $stmt->close();
        } else {
            $sql = "UPDATE projects SET nama_proyek = ?, deskripsi = ?, tanggal_mulai = ?, tanggal_selesai = ? 
                    WHERE id = ? AND manager_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssii", $nama_proyek, $deskripsi, $tanggal_mulai, $tanggal_selesai, $project_id, $manager_id);

            if ($stmt->execute()) {
                header("Location: manage_projects.php?status=updated");
                exit;
            } else {
                $message = "<div class='alert alert-danger'>Gagal mengupdate proyek: " . $conn->error . "</div>";
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?php echo $edit_id ? 'Edit' : 'Tambah'; ?> Proyek</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
            <h3 class="text-primary"><?php echo $edit_id ? 'Edit Proyek: ' . htmlspecialchars($project['nama_proyek']) : 'Tambah Proyek Baru'; ?></h3>
            <a href="manage_projects.php" class="btn btn-secondary">Batal</a>
        </div>
        
        <?php echo $message; ?>
        
        <div class="card p-4 shadow-sm border-0">
            <form action="project_form.php" method="POST">
                <?php if ($edit_id): ?>
                    <input type="hidden" name="project_id" value="<?php echo $edit_id; ?>">
                <?php endif; ?>

                <div class="form-group">
                    <label for="nama_proyek">Nama Proyek</label>
                    <input type="text" class="form-control" id="nama_proyek" name="nama_proyek" 
                           value="<?php echo htmlspecialchars($project['nama_proyek']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required><?php echo htmlspecialchars($project['deskripsi']); ?></textarea>
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

                <button type="submit" class="btn btn-primary mt-3">
                    <?php echo $edit_id ? '💾 Update Proyek' : '➕ Simpan Proyek'; ?>
                </button>
            </form>
        </div>

    </div>
</body>
</html>