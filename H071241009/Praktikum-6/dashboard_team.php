<?php
/*
 * File: dashboard_team.php
 * Deskripsi: Halaman utama untuk Team Member (Lihat Tugas & Stats).
 */

require_once 'config.php';
require_once 'includes/auth_check.php'; // Wajib! Cek login

// Cek spesifik role
if ($_SESSION['role'] !== 'Team Member') {
    die("Akses ditolak: Anda bukan Team Member.");
}

$team_member_id = $_SESSION['id'];

// ---- (BARU) KODE STATISTIK TEAM MEMBER ----
$total_my_tasks = 0;
$my_task_statuses = ['belum' => 0, 'proses' => 0, 'selesai' => 0];

// 1. Total Tugas & Statusnya (hanya milik user ini)
$stmt_task_status = $conn->prepare("SELECT status, COUNT(id) AS total FROM tasks WHERE assigned_to = ? GROUP BY status");
$stmt_task_status->bind_param("i", $team_member_id);
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


// Ambil semua tugas yang ditugaskan ke user ini (untuk tabel)
$task_list = [];
$sql_tasks = "SELECT 
                t.id AS task_id, 
                t.nama_tugas, 
                t.deskripsi, 
                t.status, 
                p.nama_proyek 
              FROM tasks t
              JOIN projects p ON t.project_id = p.id
              WHERE t.assigned_to = ?
              ORDER BY p.nama_proyek, t.id DESC";

$stmt = $conn->prepare($sql_tasks);
$stmt->bind_param("i", $team_member_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $task_list[] = $row;
    }
}
$stmt->close();
$conn->close();

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Team Member</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Dashboard Team Member</a>
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
        
        <div class="row mt-4 justify-content-center">
            <div class="col-md-8">
                <div class="card bg-light shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                             <h5 class="card-title mb-0">Status Tugas Saya (Total: <?php echo $total_my_tasks; ?>)</h5>
                             <i class="bi bi-clipboard-data" style="font-size: 2.5rem; color: #6c757d;"></i>
                        </div>
                        <div class="d-flex justify-content-around text-center pt-2">
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


        <div class="card mt-4">
            <div class="card-header">
                <strong>Daftar Tugas Anda</strong>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Nama Proyek</th>
                                <th>Nama Tugas</th>
                                <th>Deskripsi</th>
                                <th>Status Saat Ini</th>
                                <th>Ubah Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($task_list)): ?>
                                <tr>
                                    <td colspan="5" class="text-center">Anda belum memiliki tugas.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($task_list as $task): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($task['nama_proyek']); ?></td>
                                    <td><?php echo htmlspecialchars($task['nama_tugas']); ?></td>
                                    <td><?php echo htmlspecialchars($task['deskripsi']); ?></td>
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
                                    <td>
                                        <form action="team_update_status.php" method="POST" class="d-flex">
                                            <input type="hidden" name="task_id" value="<?php echo $task['task_id']; ?>">
                                            <select name="new_status" class="form-select form-select-sm me-2">
                                                <option value="belum" <?php echo ($task['status'] == 'belum') ? 'selected' : ''; ?>>Belum</option>
                                                <option value="proses" <?php echo ($task['status'] == 'proses') ? 'selected' : ''; ?>>Proses</option>
                                                <option value="selesai" <?php echo ($task['status'] == 'selesai') ? 'selected' : ''; ?>>Selesai</option>
                                            </select>
                                            <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                        </form>
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
</body>
</html>