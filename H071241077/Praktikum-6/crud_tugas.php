<?php
session_start();
require 'koneksi.php';

// =======================
// CEK LOGIN
// =======================
if (!isset($_SESSION['user'])) {
    die("Akses ditolak. Harap login terlebih dahulu.");
}

$role = strtoupper($_SESSION['user']['role']);
$user_id = $_SESSION['user']['id'];

// =======================
// CSS Helper Functions (simulating CSS classes)
// =======================
// Fungsi untuk menghasilkan badge status
function get_status_badge($status) {
    $class = '';
    switch ($status) {
        case 'belum':
            $class = "background-color: #EF4444; color: white;";
            break;
        case 'proses':
            $class = "background-color: #F59E0B; color: white;";
            break;
        case 'selesai':
            $class = "background-color: #10B981; color: white;";
            break;
        default:
            $class = "background-color: #9CA3AF; color: white;";
    }
    return "<span style='padding: 4px 12px; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; text-transform: capitalize; $class'>" . htmlspecialchars($status) . "</span>";
}

// =======================
// ROLE MEMBER → LANGSUNG UBAH STATUS
// =======================
if ($role === 'MEMBER') {
    $tugas_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $sql = "SELECT t.id, t.nama_tugas, t.status, p.nama_proyek
            FROM tasks t
            JOIN projects p ON t.project_id = p.id
            WHERE t.id=? AND t.assigned_to=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $tugas_id, $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $task = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$task) {
        die("Tugas tidak ditemukan atau Anda tidak memiliki akses.");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $status = $_POST['status'];
        $update = mysqli_prepare($conn, "UPDATE tasks SET status=? WHERE id=? AND assigned_to=?");
        mysqli_stmt_bind_param($update, "sii", $status, $tugas_id, $user_id);
        mysqli_stmt_execute($update);
        mysqli_stmt_close($update);

        header("Location: member_dashboard.php");
        exit();
    }

    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Ubah Status Tugas</title>
        <style>
            body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #F5F5F5; margin: 0; padding: 0; min-height: 100vh; }
            .header { background-color: #6D4C41; color: white; padding: 15px 25px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
            .header h1 { margin: 0; font-size: 1.25rem; }
            .btn-back { background-color: #A1887F; color: white; padding: 8px 15px; border-radius: 8px; text-decoration: none; font-size: 0.9rem; transition: background-color 0.3s; }
            .btn-back:hover { background-color: #8D6E63; }
            .main-container { max-width: 500px; margin: 40px auto; background-color: white; padding: 30px; border-radius: 12px; box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1); border-top: 5px solid #A1887F; }
            .form-title { font-size: 1.5rem; color: #4B4B4B; margin-bottom: 20px; border-bottom: 1px solid #E0E0E0; padding-bottom: 10px; }
            .form-group { margin-bottom: 20px; }
            .form-group label { display: block; color: #4B4B4B; font-weight: 600; margin-bottom: 8px; }
            .form-control { width: 100%; padding: 12px; border: 1px solid #D1D5DB; border-radius: 8px; box-sizing: border-box; font-size: 1rem; transition: border-color 0.3s, box-shadow 0.3s; }
            .form-control:focus { border-color: #A1887F; outline: none; box-shadow: 0 0 0 3px rgba(161, 136, 127, 0.2); }
            .btn-submit { width: 100%; background-color: #6D4C41; color: white; padding: 12px; border: none; border-radius: 8px; font-size: 1rem; font-weight: 700; cursor: pointer; transition: background-color 0.3s, transform 0.1s; }
            .btn-submit:hover { background-color: #A1887F; }
            .btn-submit:active { transform: scale(0.99); }
        </style>
    </head>
    <body>
        <header class="header">
            <h1>Ubah Status Tugas</h1>
            <a href="member_dashboard.php" class="btn-back">Kembali</a>
        </header>

        <main class="main-container">
            <h2 class="form-title"><?= htmlspecialchars($task['nama_tugas']) ?></h2>
            <p style="color: #6B6B6B; margin-bottom: 20px;">Proyek: <?= htmlspecialchars($task['nama_proyek']) ?></p>

            <form method="POST">
                <div class="form-group">
                    <label>Status Saat Ini:</label>
                    <div style="margin-bottom: 15px;"><?= get_status_badge($task['status']) ?></div>
                    
                    <label for="status_select">Ubah Status:</label>
                    <select name="status" id="status_select" required class="form-control">
                        <option value="belum" <?= $task['status'] === 'belum' ? 'selected' : '' ?>>Belum</option>
                        <option value="proses" <?= $task['status'] === 'proses' ? 'selected' : '' ?>>Proses</option>
                        <option value="selesai" <?= $task['status'] === 'selesai' ? 'selected' : '' ?>>Selesai</option>
                    </select>
                </div>

                <button type="submit" class="btn-submit">
                    Simpan Perubahan
                </button>
            </form>
        </main>
    </body>
    </html>
    <?php
    exit();
}


// =======================
// ROLE MANAGER → CRUD TUGAS
// =======================
if ($role !== 'MANAGER') {
    die("Akses ditolak");
}

$manager_id  = $user_id;
$project_id  = $_GET['project_id'] ?? 0;
$pemberitahuan = "";


// =======================
// MODE: UBAH STATUS (MANAGER)
// =======================
if (isset($_GET['ubah_status_id'])) {
    $id_tugas = (int)$_GET['ubah_status_id'];
    $sql = "SELECT t.*, p.nama_proyek 
            FROM tasks t
            JOIN projects p ON t.project_id = p.id
            WHERE t.id=? AND p.manager_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $id_tugas, $manager_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $task = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$task) {
        die("Tugas tidak ditemukan atau tidak boleh diakses.");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $status = $_POST['status'];
        $sql = "UPDATE tasks t
                JOIN projects p ON t.project_id = p.id
                SET t.status=?
                WHERE t.id=? AND p.manager_id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sii", $status, $id_tugas, $manager_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("Location: crud_tugas.php?project_id=" . $task['project_id']);
        exit();
    }

    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Ubah Status Tugas</title>
        <style>
            body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #F5F5F5; margin: 0; padding: 0; min-height: 100vh; }
            .header { background-color: #6D4C41; color: white; padding: 15px 25px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
            .header h1 { margin: 0; font-size: 1.25rem; }
            .btn-back { background-color: #A1887F; color: white; padding: 8px 15px; border-radius: 8px; text-decoration: none; font-size: 0.9rem; transition: background-color 0.3s; }
            .btn-back:hover { background-color: #8D6E63; }
            .main-container { max-width: 500px; margin: 40px auto; background-color: white; padding: 30px; border-radius: 12px; box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1); border-top: 5px solid #A1887F; }
            .form-title { font-size: 1.5rem; color: #4B4B4B; margin-bottom: 20px; border-bottom: 1px solid #E0E0E0; padding-bottom: 10px; }
            .form-group { margin-bottom: 20px; }
            .form-group label { display: block; color: #4B4B4B; font-weight: 600; margin-bottom: 8px; }
            .form-control { width: 100%; padding: 12px; border: 1px solid #D1D5DB; border-radius: 8px; box-sizing: border-box; font-size: 1rem; transition: border-color 0.3s, box-shadow 0.3s; }
            .form-control:focus { border-color: #A1887F; outline: none; box-shadow: 0 0 0 3px rgba(161, 136, 127, 0.2); }
            .btn-submit { width: 100%; background-color: #6D4C41; color: white; padding: 12px; border: none; border-radius: 8px; font-size: 1rem; font-weight: 700; cursor: pointer; transition: background-color 0.3s, transform 0.1s; }
            .btn-submit:hover { background-color: #A1887F; }
            .btn-submit:active { transform: scale(0.99); }
        </style>
    </head>
    <body>
        <header class="header">
            <h1>Ubah Status Tugas</h1>
            <a href="crud_tugas.php?project_id=<?= $task['project_id'] ?>" class="btn-back">Kembali</a>
        </header>

        <main class="main-container">
            <h2 class="form-title">
                <?= htmlspecialchars($task['nama_tugas']) ?> 
                (<span style="font-weight: normal; font-size: 1rem; color: #757575;"><?= htmlspecialchars($task['nama_proyek']) ?></span>)
            </h2>

            <form method="POST">
                <div class="form-group">
                    <label>Status Saat Ini:</label>
                    <div style="margin-bottom: 15px;"><?= get_status_badge($task['status']) ?></div>
                    
                    <label for="status_select">Ubah Status:</label>
                    <select name="status" id="status_select" required class="form-control">
                        <option value="belum" <?= $task['status'] === 'belum' ? 'selected' : '' ?>>Belum</option>
                        <option value="proses" <?= $task['status'] === 'proses' ? 'selected' : '' ?>>Proses</option>
                        <option value="selesai" <?= $task['status'] === 'selesai' ? 'selected' : '' ?>>Selesai</option>
                    </select>
                </div>

                <button type="submit" class="btn-submit">
                    Simpan
                </button>
            </form>
        </main>
    </body>
    </html>
    <?php
    exit();
}


// =======================
// HAPUS TUGAS
// =======================
if (isset($_GET['hapus_id']) && isset($_GET['project_id'])) {
    $hapus_id = (int)$_GET['hapus_id'];
    $project_id = (int)$_GET['project_id'];

    $sql = "DELETE t FROM tasks t
            JOIN projects p ON t.project_id = p.id
            WHERE t.id=? AND p.manager_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $hapus_id, $manager_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: crud_tugas.php?project_id=$project_id");
    exit();
}


// =======================
// TAMBAH TUGAS
// =======================
if (isset($_POST['tambah'])) {
    $nama_tugas  = trim($_POST['nama_tugas']);
    $assigned_to = $_POST['assigned_to'];
    $project_id  = $_POST['project_id'];

    if (!empty($nama_tugas) && !empty($assigned_to) && !empty($project_id)) {
        $cek = mysqli_prepare($conn, "SELECT COUNT(*) FROM tasks WHERE nama_tugas=? AND project_id=?");
        mysqli_stmt_bind_param($cek, "si", $nama_tugas, $project_id);
        mysqli_stmt_execute($cek);
        mysqli_stmt_bind_result($cek, $jumlah);
        mysqli_stmt_fetch($cek);
        mysqli_stmt_close($cek);

        if ($jumlah > 0) {
            $pemberitahuan = "Tugas dengan nama '$nama_tugas' sudah ada dalam proyek ini.";
        } else {
            $sql = "INSERT INTO tasks (nama_tugas, project_id, assigned_to) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sii", $nama_tugas, $project_id, $assigned_to);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            $pemberitahuan = "Tugas '$nama_tugas' berhasil ditambahkan.";
        }
    } else {
        $pemberitahuan = "Semua field wajib diisi!";
    }
}


// =======================
// AMBIL DATA PROYEK & TUGAS
// =======================
$project_list = [];
$res = mysqli_prepare($conn, "SELECT id, nama_proyek FROM projects WHERE manager_id=?");
mysqli_stmt_bind_param($res, "i", $manager_id);
mysqli_stmt_execute($res);
$r = mysqli_stmt_get_result($res);
while ($row = mysqli_fetch_assoc($r)) $project_list[] = $row;
mysqli_stmt_close($res);

if ($project_id == 0 && count($project_list) > 0) $project_id = $project_list[0]['id'];

$members = [];
$res = mysqli_prepare($conn, "SELECT id, username FROM users WHERE role='MEMBER' AND project_manager_id=?");
mysqli_stmt_bind_param($res, "i", $manager_id);
mysqli_stmt_execute($res);
$r = mysqli_stmt_get_result($res);
while ($row = mysqli_fetch_assoc($r)) $members[] = $row;
mysqli_stmt_close($res);

$tasks = [];
if ($project_id != 0) {
    $res = mysqli_prepare($conn, "SELECT t.id, t.nama_tugas, t.status, u.username AS member
                                FROM tasks t
                                JOIN users u ON t.assigned_to=u.id
                                WHERE t.project_id=? ORDER BY t.id ASC");
    mysqli_stmt_bind_param($res, "i", $project_id);
    mysqli_stmt_execute($res);
    $r = mysqli_stmt_get_result($res);
    while ($row = mysqli_fetch_assoc($r)) $tasks[] = $row;
    mysqli_stmt_close($res);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Tugas Proyek</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #F5F5F5; margin: 0; padding: 0; min-height: 100vh; color: #333; }
        .header { background-color: #6D4C41; color: white; padding: 15px 25px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); }
        .header h1 { margin: 0; font-size: 1.5rem; font-weight: 700; }
        .btn-dashboard { background-color: #8D6E63; color: white; padding: 8px 18px; border-radius: 8px; text-decoration: none; font-size: 1rem; transition: background-color 0.3s; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
        .btn-dashboard:hover { background-color: #A1887F; }
        .main-content { max-width: 1200px; margin: 25px auto; padding: 0 25px; display: flex; flex-direction: column; gap: 25px; }
        .notification { padding: 15px; background-color: #FFFBEA; border: 1px solid #FBCF6F; color: #92400E; border-radius: 8px; font-weight: 500; }
        .project-select-form { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; background-color: white; padding: 15px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); }
        .project-select-form label { font-weight: 600; color: #4B4B4B; }
        .project-select-form select { padding: 10px 15px; border: 1px solid #D1D5DB; border-radius: 8px; font-size: 1rem; cursor: pointer; background-color: #FFFFFF; transition: border-color 0.3s; }
        .project-select-form select:focus { border-color: #A1887F; outline: none; }
        .data-container { display: grid; grid-template-columns: 2fr 1fr; gap: 25px; align-items: start; }
        .task-list-box { background-color: white; padding: 25px; border-radius: 12px; box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1); }
        .task-list-box h2 { font-size: 1.5rem; font-weight: 700; color: #4B4B4B; margin-bottom: 20px; }
        .task-table { width: 100%; border-collapse: collapse; }
        .task-table thead { background-color: #EFEBE9; border-bottom: 2px solid #D7CCC8; }
        .task-table th { padding: 12px; text-align: left; font-size: 0.875rem; font-weight: 600; color: #6D4C41; }
        .task-table td { padding: 12px; border-bottom: 1px solid #E0E0E0; }
        .task-table tr:hover { background-color: #FAF8F6; }
        .btn-action { padding: 6px 10px; border-radius: 6px; text-decoration: none; font-size: 0.8rem; font-weight: 600; transition: opacity 0.3s; margin-right: 5px; display: inline-block;}
        .btn-status { background-color: #FBBF24; color: white; } /* Amber for Status */
        .btn-status:hover { background-color: #D97706; }
        .btn-delete { background-color: #EF4444; color: white; } /* Red for Delete */
        .btn-delete:hover { background-color: #DC2626; }
        .add-task-box { background-color: white; padding: 25px; border-radius: 12px; box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1); border-left: 5px solid #A1887F; }
        .add-task-box h2 { font-size: 1.5rem; font-weight: 700; color: #4B4B4B; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; color: #4B4B4B; font-weight: 600; margin-bottom: 5px; font-size: 0.9rem; }
        .form-control { width: 100%; padding: 10px; border: 1px solid #D1D5DB; border-radius: 6px; box-sizing: border-box; font-size: 0.95rem; }
        .form-control:focus { border-color: #A1887F; outline: none; box-shadow: 0 0 0 3px rgba(161, 136, 127, 0.2); }
        .btn-add { width: 100%; background-color: #6D4C41; color: white; padding: 12px; border: none; border-radius: 8px; font-size: 1rem; font-weight: 700; cursor: pointer; transition: background-color 0.3s; margin-top: 10px; }
        .btn-add:hover { background-color: #A1887F; }

        /* Responsif */
        @media (max-width: 900px) {
            .data-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<header class="header">
    <h1>Manajemen Tugas Proyek</h1>
    <a href="manager_dashboard.php" class="btn-dashboard">Kembali ke Dashboard</a>
</header>

<main class="main-content">
    <?php if (!empty($pemberitahuan)): ?>
        <div class="notification">
            <?= htmlspecialchars($pemberitahuan) ?>
        </div>
    <?php endif; ?>

    <form method="GET" class="project-select-form">
        <label for="project_select">Pilih Proyek:</label>
        <select name="project_id" id="project_select" onchange="this.form.submit()">
            <?php foreach ($project_list as $proj): ?>
                <option value="<?= $proj['id'] ?>" <?= $proj['id']==$project_id?'selected':'' ?>>
                    <?= htmlspecialchars($proj['nama_proyek']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>
    
    <?php if ($project_id != 0): ?>
    <div class="data-container">
        
        <div class="task-list-box">
            <h2>Daftar Tugas</h2>
            <?php if (empty($tasks)): ?>
                <p style="color: #6B6B6B;">Belum ada tugas untuk proyek ini.</p>
            <?php else: ?>
                <table class="task-table">
                    <thead>
                        <tr>
                            <th>Tugas</th>
                            <th>Assigned To</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tasks as $t): ?>
                            <tr>
                                <td><?= htmlspecialchars($t['nama_tugas']) ?></td>
                                <td><?= htmlspecialchars($t['member']) ?></td>
                                <td><?= get_status_badge($t['status']) ?></td>
                                <td>
                                    <a href="crud_tugas.php?ubah_status_id=<?= $t['id'] ?>&project_id=<?= $project_id ?>"
                                       class="btn-action btn-status">Ubah Status</a>
                                    <a href="crud_tugas.php?hapus_id=<?= $t['id'] ?>&project_id=<?= $project_id ?>"
                                       onclick="return confirm('Yakin ingin menghapus tugas ini?')"
                                       class="btn-action btn-delete">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <div class="add-task-box">
            <h2>Tambah Tugas Baru</h2>
            <form method="POST">
                <input type="hidden" name="project_id" value="<?= $project_id ?>">
                <div class="form-group">
                    <label for="nama_tugas">Nama Tugas:</label>
                    <input type="text" id="nama_tugas" name="nama_tugas" required class="form-control">
                </div>
                <div class="form-group">
                    <label for="assigned_to">Assign ke Member:</label>
                    <select id="assigned_to" name="assigned_to" required class="form-control">
                        <?php if (empty($members)): ?>
                            <option value="">Tidak ada member tersedia</option>
                        <?php else: ?>
                            <?php foreach ($members as $m): ?>
                                <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['username']) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <button type="submit" name="tambah" class="btn-add" <?= empty($members) ? 'disabled' : '' ?>>
                    Tambah Tugas
                </button>
            </form>
        </div>
    </div>
    <?php else: ?>
        <div class="task-list-box">
            <p style="color: #6B6B6B;">Silakan buat dan pilih proyek terlebih dahulu.</p>
        </div>
    <?php endif; ?>
</main>
</body>
</html> 