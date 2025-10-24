<?php
/*
 * File: dashboard_admin.php
 * Deskripsi: Halaman utama untuk Super Admin (Manajemen User, Proyek, & Stats).
 */

require_once 'config.php';
require_once 'includes/auth_check.php'; // Wajib! Cek login

// Cek spesifik role
if ($_SESSION['role'] !== 'Super Admin') {
    die("Akses ditolak: Anda bukan Super Admin.");
}

// ---- KODE STATISTIK SUPER ADMIN ----
$total_projects = 0;
$total_tasks = 0;
$total_users = 0;
$task_statuses = ['belum' => 0, 'proses' => 0, 'selesai' => 0];

// 1. Total Proyek
$result_proj_count = $conn->query("SELECT COUNT(id) AS total FROM projects");
$total_projects = $result_proj_count->fetch_assoc()['total'];

// 2. Total User
$result_user_count = $conn->query("SELECT COUNT(id) AS total FROM users");
$total_users = $result_user_count->fetch_assoc()['total'];

// 3. Total Tugas & Statusnya
$result_task_status = $conn->query("SELECT status, COUNT(id) AS total FROM tasks GROUP BY status");
if ($result_task_status->num_rows > 0) {
    while ($row = $result_task_status->fetch_assoc()) {
        if (isset($task_statuses[$row['status']])) {
            $task_statuses[$row['status']] = $row['total'];
            $total_tasks += $row['total'];
        }
    }
}
// ---- AKHIR KODE STATISTIK ----


// 1. Ambil data semua Project Manager (untuk dropdown)
$pm_list = [];
$sql_pm = "SELECT id, username FROM users WHERE role = 'Project Manager'";
$result_pm = $conn->query($sql_pm);
if ($result_pm->num_rows > 0) {
    while($row = $result_pm->fetch_assoc()) {
        $pm_list[] = $row;
    }
}

// 2. Ambil data semua user (untuk tabel)
$user_list = [];
$sql_users = "SELECT u.id, u.username, u.role, pm.username AS manager_name 
              FROM users u 
              LEFT JOIN users pm ON u.project_manager_id = pm.id 
              ORDER BY u.role, u.username";
$result_users = $conn->query($sql_users);
if ($result_users->num_rows > 0) {
    while($row = $result_users->fetch_assoc()) {
        $user_list[] = $row;
    }
}

// 3. Ambil data SEMUA proyek
$project_list = [];
$sql_projects = "SELECT p.id, p.nama_proyek, p.tanggal_mulai, p.tanggal_selesai, u.username AS manager_name
                 FROM projects p
                 LEFT JOIN users u ON p.manager_id = u.id
                 ORDER BY p.id DESC";
$result_projects = $conn->query($sql_projects);
if ($result_projects->num_rows > 0) {
    while($row = $result_projects->fetch_assoc()) {
        $project_list[] = $row;
    }
}

$conn->close(); // Tutup koneksi
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Super Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="dashboard_admin.php">Dashboard Super Admin</a>
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
        <p>Anda login sebagai: <strong><?php echo $_SESSION['role']; ?></strong></p>

        <div class="row mt-4">
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-primary shadow">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="card-title"><?php echo $total_projects; ?></h3>
                            <p class="card-text mb-0">Total Proyek</p>
                        </div>
                        <i class="bi bi-folder-check" style="font-size: 3rem;"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-info shadow">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="card-title"><?php echo $total_users; ?></h3>
                            <p class="card-text mb-0">Total User</p>
                        </div>
                        <i class="bi bi-people-fill" style="font-size: 3rem;"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card bg-light shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Status Tugas (Total: <?php echo $total_tasks; ?>)</h5>
                        <div class="d-flex justify-content-around text-center">
                            <div>
                                <h4 class="mb-0 text-secondary"><?php echo $task_statuses['belum']; ?></h4>
                                <small>Belum</small>
                            </div>
                            <div>
                                <h4 class="mb-0 text-warning"><?php echo $task_statuses['proses']; ?></h4>
                                <small>Proses</small>
                            </div>
                            <div>
                                <h4 class="mb-0 text-success"><?php echo $task_statuses['selesai']; ?></h4>
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
                    <div class="card-header"><strong>Form Tambah User Baru</strong></div>
                    <div class="card-body">
                        <form action="admin_tambah_user.php" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select class="form-select" id="role" name="role" required onchange="toggleProjectManager()">
                                    <option value="">Pilih Role ...</option>
                                    <option value="Project Manager">Project Manager</option>
                                    <option value="Team Member">Team Member</option>
                                </select>
                            </div>
                            <div class="mb-3" id="pm-select-div" style="display: none;">
                                <label for="project_manager_id" class="form-label">Pilih Project Manager</label>
                                <select class="form-select" id="project_manager_id" name="project_manager_id">
                                    <option value="">Pilih PM ...</option>
                                    <?php foreach ($pm_list as $pm): ?>
                                        <option value="<?php echo $pm['id']; ?>"><?php echo htmlspecialchars($pm['username']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Tambah User</button>
                        </form>
                        </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header"><strong>Daftar User Sistem</strong></div>
                    <div class="card-body">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th> <th>Username</th> 
                                    <th>Role</th> 
                                    <th>Manager</th> 
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i_user = 1; // Buat counter ?>
                                <?php foreach ($user_list as $user): ?>
                                <tr>
                                    <td><?php echo $i_user++; ?></td> <td><?php echo htmlspecialchars($user['username']); ?></td>
                                    <td><?php echo htmlspecialchars($user['role']); ?></td>
                                    <td><?php echo $user['manager_name'] ? htmlspecialchars($user['manager_name']) : 'N/A'; ?></td>
                                    <td>
                                        <a href="admin_edit_user.php?id=<?php echo $user['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <?php if ($user['id'] != $_SESSION['id']): ?>
                                            <a href="admin_hapus_user.php?id=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?');">Hapus</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        </div>
                </div>
            </div>
        </div>
        
        <hr class="my-4">
        <h3>Manajemen Proyek (Semua Proyek)</h3>
        <div class="card">
            <div class="card-header"><strong>Daftar Semua Proyek Aktif</strong></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No.</th> <th>Nama Proyek</th> 
                                <th>Project Manager</th> 
                                <th>Mulai</th> 
                                <th>Selesai</th> 
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($project_list)): ?>
                                <tr><td colspan="6" class="text-center">Belum ada proyek apapun di sistem.</td></tr>
                            <?php else: ?>
                                <?php $i_proj = 1; // Buat counter ?>
                                <?php foreach ($project_list as $project): ?>
                                <tr>
                                    <td><?php echo $i_proj++; ?></td> <td><?php echo htmlspecialchars($project['nama_proyek']); ?></td>
                                    <td><?php echo $project['manager_name'] ? htmlspecialchars($project['manager_name']) : 'N/A'; ?></td>
                                    <td><?php echo $project['tanggal_mulai']; ?></td>
                                    <td><?php echo $project['tanggal_selesai']; ?></td>
                                    <td>
                                        <a href="admin_hapus_proyek.php?id=<?php echo $project['id']; ?>" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Yakin ingin menghapus proyek ini? Ini akan menghapus semua tugas di dalamnya.');">
                                           Hapus Proyek
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function toggleProjectManager() {
            var roleSelect = document.getElementById('role');
            var pmSelectDiv = document.getElementById('pm-select-div');
            var pmSelect = document.getElementById('project_manager_id');
            if (roleSelect.value === 'Team Member') {
                pmSelectDiv.style.display = 'block';
                pmSelect.required = true;
            } else {
                pmSelectDiv.style.display = 'none';
                pmSelect.required = false;
                pmSelect.value = "";
            }
        }
    </script>
</body>
</html>