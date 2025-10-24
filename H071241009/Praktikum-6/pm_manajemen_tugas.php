<?php
/*
 * File: pm_manajemen_tugas.php
 * Deskripsi: Halaman untuk PM mengelola (CRUD) tugas dalam satu proyek.
 */

require_once 'config.php';
require_once 'includes/auth_check.php';

// Proteksi: Hanya Project Manager
if ($_SESSION['role'] !== 'Project Manager') {
    die("Akses ditolak.");
}

$pm_id = $_SESSION['id'];
$is_editing = false;
$edit_task = null;

// 1. Validasi Project ID dari URL
if (!isset($_GET['project_id'])) {
    header('Location: dashboard_pm.php');
    exit;
}
$project_id = $_GET['project_id'];

// 2. Ambil detail proyek & pastikan proyek ini milik PM yang login
$stmt_project = $conn->prepare("SELECT nama_proyek FROM projects WHERE id = ? AND manager_id = ?");
$stmt_project->bind_param("ii", $project_id, $pm_id);
$stmt_project->execute();
$result_project = $stmt_project->get_result();
if ($result_project->num_rows === 0) {
    $_SESSION['message'] = "Proyek tidak ditemukan atau Anda tidak punya akses.";
    $_SESSION['msg_type'] = "danger";
    header('Location: dashboard_pm.php');
    exit;
}
$project = $result_project->fetch_assoc();
$nama_proyek = $project['nama_proyek'];
$stmt_project->close();


// 3. Cek jika sedang mode EDIT TUGAS
if (isset($_GET['edit_task'])) {
    $task_id_to_edit = $_GET['edit_task'];
    
    // Ambil data tugas yg mau diedit, pastikan dari proyek yg benar
    $stmt_edit_task = $conn->prepare("SELECT * FROM tasks WHERE id = ? AND project_id = ?");
    $stmt_edit_task->bind_param("ii", $task_id_to_edit, $project_id);
    $stmt_edit_task->execute();
    $result_edit_task = $stmt_edit_task->get_result();
    
    if ($result_edit_task->num_rows === 1) {
        $is_editing = true;
        $edit_task = $result_edit_task->fetch_assoc();
    } else {
        $_SESSION['message'] = "Tugas tidak ditemukan.";
        $_SESSION['msg_type'] = "warning";
        header('Location: pm_manajemen_tugas.php?project_id=' . $project_id);
        exit;
    }
    $stmt_edit_task->close();
}


// 4. Ambil daftar Team Member (untuk dropdown)
$team_list = [];
$stmt_team = $conn->prepare("SELECT id, username FROM users WHERE role = 'Team Member' AND project_manager_id = ?");
$stmt_team->bind_param("i", $pm_id);
$stmt_team->execute();
$result_team = $stmt_team->get_result();
if ($result_team->num_rows > 0) {
    while ($row = $result_team->fetch_assoc()) {
        $team_list[] = $row;
    }
}
$stmt_team->close();

// 5. Ambil daftar tugas untuk proyek ini
$task_list = [];
$sql_tasks = "SELECT t.id, t.nama_tugas, t.deskripsi, t.status, u.username AS assigned_user
              FROM tasks t
              LEFT JOIN users u ON t.assigned_to = u.id
              WHERE t.project_id = ?
              ORDER BY t.id DESC";
$stmt_tasks = $conn->prepare($sql_tasks);
$stmt_tasks->bind_param("i", $project_id);
$stmt_tasks->execute();
$result_tasks = $stmt_tasks->get_result();
if ($result_tasks->num_rows > 0) {
    while ($row = $result_tasks->fetch_assoc()) {
        $task_list[] = $row;
    }
}
$stmt_tasks->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="dashboard_pm.php">Kembali ke Dashboard PM</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
            </div>
    </nav>
    <div class="container mt-4">
        <h2>Manajemen Tugas untuk Proyek:</h2>
        <h3 class="text-muted"><?php echo htmlspecialchars($nama_proyek); ?></h3>
        
        <hr>

        <?php if(isset($_SESSION['message'])): ?>
            <div class="alert alert-<?php echo $_SESSION['msg_type']; ?> alert-dismissible fade show" role="alert">
                <?php
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                    unset($_SESSION['msg_type']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <strong><?php echo $is_editing ? 'Edit Tugas' : 'Form Tambah Tugas Baru'; ?></strong>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $is_editing ? 'pm_update_tugas.php' : 'pm_tambah_tugas.php'; ?>" method="POST">
                            
                            <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
                            <?php if ($is_editing): ?>
                                <input type="hidden" name="task_id" value="<?php echo $edit_task['id']; ?>">
                            <?php endif; ?>

                            <div class="mb-3">
                                <label for="nama_tugas" class="form-label">Nama Tugas</label>
                                <input type="text" class="form-control" id="nama_tugas" name="nama_tugas" 
                                       value="<?php echo $is_editing ? htmlspecialchars($edit_task['nama_tugas']) : ''; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi Tugas</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"><?php echo $is_editing ? htmlspecialchars($edit_task['deskripsi']) : ''; ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="assigned_to" class="form-label">Tetapkan ke Team Member</label>
                                <select class="form-select" id="assigned_to" name="assigned_to" required>
                                    <option value="">Pilih Team Member...</option>
                                    <?php foreach ($team_list as $team): ?>
                                        <option value="<?php echo $team['id']; ?>" <?php echo ($is_editing && $edit_task['assigned_to'] == $team['id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($team['username']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">
                                <?php echo $is_editing ? 'Update Tugas' : 'Tambah Tugas'; ?>
                            </button>
                            <?php if ($is_editing): ?>
                                <a href="pm_manajemen_tugas.php?project_id=<?php echo $project_id; ?>" class="btn btn-secondary w-100 mt-2">Batal Edit</a>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <strong>Daftar Tugas Proyek</strong>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Nama Tugas</th>
                                        <th>Deskripsi</th>
                                        <th>Status</th>
                                        <th>Dikerjakan Oleh</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($task_list)): ?>
                                        <tr>
                                            <td colspan="5" class="text-center">Belum ada tugas untuk proyek ini.</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($task_list as $task): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($task['nama_tugas']); ?></td>
                                            <td><?php echo htmlspecialchars(substr($task['deskripsi'], 0, 40)) . '...'; ?></td>
                                            <td>
                                                <span class="badge 
                                                    <?php 
                                                        if ($task['status'] == 'selesai') echo 'bg-success';
                                                        elseif ($task['status'] == 'proses') echo 'bg-warning text-dark';
                                                        else echo 'bg-secondary'; 
                                                    ?>">
                                                    <?php echo ucfirst($task['status']); ?>
                                                </span>
                                            </td>
                                            <td><?php echo $task['assigned_user'] ? htmlspecialchars($task['assigned_user']) : 'N/A'; ?></td>
                                            <td>
                                                <a href="pm_manajemen_tugas.php?project_id=<?php echo $project_id; ?>&edit_task=<?php echo $task['id']; ?>" 
                                                   class="btn btn-warning btn-sm">
                                                   Edit
                                                </a>
                                                <a href="pm_hapus_tugas.php?id=<?php echo $task['id']; ?>&project_id=<?php echo $project_id; ?>" 
                                                   class="btn btn-danger btn-sm" 
                                                   onclick="return confirm('Yakin ingin menghapus tugas ini?');">
                                                   Hapus
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>