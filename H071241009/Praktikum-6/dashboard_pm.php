<?php
/*
 * File: dashboard_pm.php
 * Deskripsi: Halaman utama untuk Project Manager (CRUD Proyek & Stats).
 */

require_once 'config.php';
require_once 'includes/auth_check.php'; // Wajib! Cek login

// Cek spesifik role
if ($_SESSION['role'] !== 'Project Manager') {
    die("Akses ditolak: Anda bukan Project Manager.");
}

$manager_id = $_SESSION['id']; // ID PM yang sedang login

// ---- (BARU) KODE STATISTIK PROJECT MANAGER ----
$total_my_projects = 0;
$total_my_tasks = 0;
$total_my_team = 0;
$my_task_statuses = ['belum' => 0, 'proses' => 0, 'selesai' => 0];

// 1. Total Proyek Milik PM
$stmt_proj_count = $conn->prepare("SELECT COUNT(id) AS total FROM projects WHERE manager_id = ?");
$stmt_proj_count->bind_param("i", $manager_id);
$stmt_proj_count->execute();
$total_my_projects = $stmt_proj_count->get_result()->fetch_assoc()['total'];
$stmt_proj_count->close();

// 2. Total Team Member Milik PM
$stmt_team_count = $conn->prepare("SELECT COUNT(id) AS total FROM users WHERE project_manager_id = ?");
$stmt_team_count->bind_param("i", $manager_id);
$stmt_team_count->execute();
$total_my_team = $stmt_team_count->get_result()->fetch_assoc()['total'];
$stmt_team_count->close();

// 3. Total Tugas & Statusnya (dari proyek milik PM)
$sql_task_status = "SELECT t.status, COUNT(t.id) AS total 
                    FROM tasks t
                    JOIN projects p ON t.project_id = p.id
                    WHERE p.manager_id = ?
                    GROUP BY t.status";
$stmt_task_status = $conn->prepare($sql_task_status);
$stmt_task_status->bind_param("i", $manager_id);
$stmt_task_status->execute();
$result_task_status = $stmt_task_status->get_result();

if ($result_task_status->num_rows > 0) {
    while ($row = $result_task_status->fetch_assoc()) {
        if (isset($my_task_statuses[$row['status']])) {
            $my_task_statuses[$row['status']] = $row['total'];
            $total_my_tasks += $row['total'];
        }
    }
}
$stmt_task_status->close();
// ---- AKHIR KODE STATISTIK ----


// Cek jika sedang dalam mode EDIT PROYEK
$is_editing = false;
$edit_project = null;
if (isset($_GET['edit'])) {
    $project_id_to_edit = $_GET['edit'];
    $stmt_edit = $conn->prepare("SELECT * FROM projects WHERE id = ? AND manager_id = ?");
    $stmt_edit->bind_param("ii", $project_id_to_edit, $manager_id);
    $stmt_edit->execute();
    $result_edit = $stmt_edit->get_result();
    if ($result_edit->num_rows === 1) {
        $is_editing = true;
        $edit_project = $result_edit->fetch_assoc();
    } else {
        $_SESSION['message'] = "Proyek tidak ditemukan atau Anda tidak punya akses.";
        $_SESSION['msg_type'] = "danger";
        header('Location: dashboard_pm.php');
        exit;
    }
    $stmt_edit->close();
}

// Ambil semua proyek milik PM ini (untuk tabel)
$project_list = [];
$stmt_projects = $conn->prepare("SELECT * FROM projects WHERE manager_id = ? ORDER BY tanggal_mulai DESC");
$stmt_projects->bind_param("i", $manager_id);
$stmt_projects->execute();
$result_projects = $stmt_projects->get_result();
if ($result_projects->num_rows > 0) {
    while($row = $result_projects->fetch_assoc()) {
        $project_list[] = $row;
    }
}
$stmt_projects->close();
$conn->close(); // Tutup koneksi
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Project Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="dashboard_pm.php">Dashboard PM</a>
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
        <h2>Selamat Datang, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>

        <div class="row mt-4">
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-primary shadow">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="card-title"><?php echo $total_my_projects; ?></h3>
                            <p class="card-text mb-0">Proyek Saya</p>
                        </div>
                        <i class="bi bi-folder-check" style="font-size: 3rem;"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-success shadow">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="card-title"><?php echo $total_my_team; ?></h3>
                            <p class="card-text mb-0">Anggota Tim</p>
                        </div>
                        <i class="bi bi-people-fill" style="font-size: 3rem;"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card bg-light shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Status Tugas Saya (Total: <?php echo $total_my_tasks; ?>)</h5>
                        <div class="d-flex justify-content-around text-center">
                            <div>
                                <h4 class="mb-0 text-secondary"><?php echo $my_task_statuses['belum']; ?></h4>
                                <small>Belum</small>
                            </div>
                            <div>
                                <h4 class="mb-0 text-warning"><?php echo $my_task_statuses['proses']; ?></h4>
                                <small>Proses</small>
                            </div>
                            <div>
                                <h4 class="mb-0 text-success"><?php echo $my_task_statuses['selesai']; ?></h4>
                                <small>Selesai</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                <div class="card mb-4">
                    <div class="card-header">
                        <strong><?php echo $is_editing ? 'Edit Proyek' : 'Form Tambah Proyek Baru'; ?></strong>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $is_editing ? 'pm_edit_proyek.php' : 'pm_tambah_proyek.php'; ?>" method="POST">
                            <?php if ($is_editing): ?>
                                <input type="hidden" name="project_id" value="<?php echo $edit_project['id']; ?>">
                            <?php endif; ?>
                            <div class="mb-3">
                                <label for="nama_proyek" class="form-label">Nama Proyek</label>
                                <input type="text" class="form-control" id="nama_proyek" name="nama_proyek" 
                                       value="<?php echo $is_editing ? htmlspecialchars($edit_project['nama_proyek']) : ''; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"><?php echo $is_editing ? htmlspecialchars($edit_project['deskripsi']) : ''; ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai"
                                       value="<?php echo $is_editing ? $edit_project['tanggal_mulai'] : ''; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai"
                                       value="<?php echo $is_editing ? $edit_project['tanggal_selesai'] : ''; ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100"><?php echo $is_editing ? 'Update Proyek' : 'Tambah Proyek'; ?></button>
                            <?php if ($is_editing): ?>
                                <a href="dashboard_pm.php" class="btn btn-secondary w-100 mt-2">Batal Edit</a>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <strong>Daftar Proyek Anda</strong>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Nama Proyek</th> <th>Deskripsi</th> <th>Mulai</th> <th>Selesai</th> <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($project_list)): ?>
                                        <tr><td colspan="5" class="text-center">Anda belum memiliki proyek.</td></tr>
                                    <?php else: ?>
                                        <?php foreach ($project_list as $project): ?>
                                        <tr>
                                            <td>
                                                <a href="pm_manajemen_tugas.php?project_id=<?php echo $project['id']; ?>">
                                                    <strong><?php echo htmlspecialchars($project['nama_proyek']); ?></strong>
                                                </a>
                                            </td>
                                            <td><?php echo htmlspecialchars(substr($project['deskripsi'], 0, 50)) . '...'; ?></td>
                                            <td><?php echo $project['tanggal_mulai']; ?></td>
                                            <td><?php echo $project['tanggal_selesai']; ?></td>
                                            <td>
                                                <a href="dashboard_pm.php?edit=<?php echo $project['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                                <a href="pm_hapus_proyek.php?id=<?php echo $project['id']; ?>" 
                                                   class="btn btn-danger btn-sm" 
                                                   onclick="return confirm('Apakah Anda yakin ingin menghapus proyek ini? Menghapus proyek akan menghapus semua tugas di dalamnya.');">
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