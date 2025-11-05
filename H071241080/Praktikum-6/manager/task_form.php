<?php
include('../config/auth.php');
checkRole(['Project Manager']); 
$manager_id = $_SESSION['user_id'];

$task = [
    'nama_tugas' => '', 
    'deskripsi' => '', 
    'status' => 'belum',
    'assigned_to' => ''
];
$project_id = null;
$edit_task_id = null;
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

if (isset($_GET['edit_task_id'])) {
    $edit_task_id = $conn->real_escape_string($_GET['edit_task_id']);
    
    $sql_fetch = "SELECT t.* FROM tasks t 
                  JOIN projects p ON t.project_id = p.id 
                  WHERE t.id = '$edit_task_id' AND p.manager_id = '$manager_id'";
    $result_fetch = $conn->query($sql_fetch);
    
    if ($result_fetch->num_rows == 1) {
        $task = $result_fetch->fetch_assoc();
    } else {
        $message = "<div class='alert alert-danger'>Tugas tidak ditemukan atau Anda tidak memiliki izin.</div>";
        $edit_task_id = null;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_tugas = $conn->real_escape_string($_POST['nama_tugas']);
    $deskripsi = $conn->real_escape_string($_POST['deskripsi']);
    $assigned_to = $conn->real_escape_string($_POST['assigned_to']); 
    $task_id = $conn->real_escape_string($_POST['task_id'] ?? '');

    $task['nama_tugas'] = $nama_tugas;
    $task['deskripsi'] = $deskripsi;
    $task['assigned_to'] = $assigned_to;
    
    $sql_check_member = "SELECT id FROM users WHERE id = '$assigned_to' AND role = 'Team Member' AND project_manager_id = '$manager_id'";
    $check_result = $conn->query($sql_check_member);
    
    if ($check_result->num_rows == 0) {
        $message = "<div class='alert alert-danger'>Team Member yang dipilih tidak valid atau tidak berada di bawah pengawasan Anda.</div>";
    } else {
        if (empty($task_id)) {
            $sql = "INSERT INTO tasks (nama_tugas, deskripsi, project_id, assigned_to) 
                    VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssii", $nama_tugas, $deskripsi, $project_id, $assigned_to);
            
            if ($stmt->execute()) {
                header("Location: manage_tasks.php?project_id=$project_id&status=created");
                exit;
            } else {
                $message = "<div class='alert alert-danger'>Gagal menambah tugas: " . $conn->error . "</div>";
            }
            $stmt->close();
        } else {
            $sql = "UPDATE tasks SET nama_tugas = ?, deskripsi = ?, assigned_to = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssii", $nama_tugas, $deskripsi, $assigned_to, $task_id);

            if ($stmt->execute()) {
                header("Location: manage_tasks.php?project_id=$project_id&status=updated");
                exit;
            } else {
                $message = "<div class='alert alert-danger'>Gagal mengupdate tugas: " . $conn->error . "</div>";
            }
            $stmt->close();
        }
    }
}

$sql_members = "SELECT id, username FROM users WHERE role = 'Team Member' AND project_manager_id = '$manager_id' ORDER BY username";
$members_result = $conn->query($sql_members); 
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?php echo $edit_task_id ? 'Edit' : 'Tambah'; ?> Tugas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
            <h3 class="text-primary"><?php echo $edit_task_id ? 'Edit Tugas' : 'Tambah Tugas Baru'; ?> untuk Proyek: <?php echo htmlspecialchars($project_name); ?></h3>
            <a href="manage_tasks.php?project_id=<?php echo $project_id; ?>" class="btn btn-secondary">Batal</a>
        </div>
        
        <?php echo $message; ?>

        <div class="card p-4 shadow-sm border-0">
            <form action="task_form.php?project_id=<?php echo $project_id; ?>" method="POST">
                <?php if ($edit_task_id): ?>
                    <input type="hidden" name="task_id" value="<?php echo $edit_task_id; ?>">
                <?php endif; ?>

                <div class="form-group">
                    <label for="nama_tugas">Nama Tugas</label>
                    <input type="text" class="form-control" id="nama_tugas" name="nama_tugas" 
                           value="<?php echo htmlspecialchars($task['nama_tugas']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required><?php echo htmlspecialchars($task['deskripsi']); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="assigned_to">Tugaskan Kepada (Team Member)</label>
                    <select class="form-control" id="assigned_to" name="assigned_to" required>
                        <option value="">-- Pilih Team Member --</option>
                        <?php 
                        if ($members_result) $members_result->data_seek(0); 
                        while ($member = $members_result->fetch_assoc()): ?>
                            <option value="<?php echo $member['id']; ?>" 
                                    <?php echo ($task['assigned_to'] == $member['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($member['username']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                    <small class="form-text text-danger">Hanya menampilkan Team Member yang di bawah pengawasan Anda.</small>
                </div>

                <button type="submit" class="btn btn-primary mt-3">
                    <?php echo $edit_task_id ? '💾 Update Tugas' : '➕ Simpan Tugas'; ?>
                </button>
            </form>
        </div>

    </div>
</body>
</html>