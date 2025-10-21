<?php
session_start();

// Security
if (!isset($_SESSION['initiated'])) {
    session_regenerate_id(true);
    $_SESSION['initiated'] = true;
}

if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit;
}

require "connect.php";

$role = $_SESSION["role"];
$uid  = (int)$_SESSION["user_id"];
$username = htmlspecialchars($_SESSION["username"]);

function can_manage_project(mysqli $db, int $pid, int $uid, string $role): bool {
    if ($role === "super_admin") return true;
    if ($role !== "project_manager") return false;
    $s = mysqli_prepare($db, "SELECT 1 FROM projects WHERE id=? AND manager_id=?");
    mysqli_stmt_bind_param($s, "ii", $pid, $uid);
    mysqli_stmt_execute($s);
    $r = mysqli_stmt_get_result($s);
    return (bool)mysqli_fetch_row($r);
}

function can_update_task_status(mysqli $db, int $tid, int $uid): bool {
    $s = mysqli_prepare($db, "SELECT 1 FROM tasks WHERE id=? AND assigned_to=?");
    mysqli_stmt_bind_param($s, "ii", $tid, $uid);
    mysqli_stmt_execute($s);
    $r = mysqli_stmt_get_result($s);
    return (bool)mysqli_fetch_row($r);
}

// PM/super_admin: CREATE TASK
if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST["action"] ?? "") === "create") {
    if (!in_array($role, ["project_manager","super_admin"], true)) {
        http_response_code(403);
        exit("Akses ditolak");
    }
    
    $pid = (int)($_POST["project_id"] ?? 0);
    if (!can_manage_project($connect, $pid, $uid, $role)) {
        http_response_code(403);
        exit("Akses ditolak");
    }
    
    $nama = trim($_POST["nama_tugas"] ?? "");
    $desk = trim($_POST["deskripsi"] ?? "");
    $status = $_POST["status"] ?? "belum";
    $assignee_raw = $_POST["assigned_to"] ?? "";
    
    // Validasi
    if (empty($nama)) {
        header("Location: tasks.php?project={$pid}&error=" . urlencode("Nama tugas wajib diisi"));
        exit;
    }
    
    // Validasi status
    if (!in_array($status, ['belum', 'proses', 'selesai'], true)) {
        $status = 'belum';
    }
    
    $assignee = ($assignee_raw === "") ? NULL : (int)$assignee_raw;
    
    // Validasi assignee jika ada
    if ($assignee !== NULL) {
        $check = mysqli_prepare($connect, "SELECT role, project_manager_id FROM users WHERE id=?");
        mysqli_stmt_bind_param($check, "i", $assignee);
        mysqli_stmt_execute($check);
        $user = mysqli_fetch_assoc(mysqli_stmt_get_result($check));
        
        if (!$user || $user['role'] !== 'team_member') {
            header("Location: tasks.php?project={$pid}&error=" . urlencode("Hanya bisa assign ke Team Member"));
            exit;
        }
        
        // Validasi TM berada di bawah PM yang sama (jika PM yang assign)
        if ($role === 'project_manager') {
            if ((int)$user['project_manager_id'] !== $uid) {
                header("Location: tasks.php?project={$pid}&error=" . urlencode("Team Member tidak berada di bawah PM Anda"));
                exit;
            }
        }
    }
    
    $stmt = mysqli_prepare($connect, "INSERT INTO tasks (nama_tugas, deskripsi, status, project_id, assigned_to)
                                      VALUES (?,?,?,?,?)");
    mysqli_stmt_bind_param($stmt, "sssii", $nama, $desk, $status, $pid, $assignee);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: tasks.php?project={$pid}&success=" . urlencode("Task berhasil ditambahkan"));
        exit;
    } else {
        header("Location: tasks.php?project={$pid}&error=" . urlencode("Gagal menambahkan task"));
        exit;
    }
}

// PM/super_admin: UPDATE/EDIT TASK
if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST["action"] ?? "") === "edit") {
    if (!in_array($role, ["project_manager","super_admin"], true)) {
        http_response_code(403);
        exit("Akses ditolak");
    }
    
    $tid = (int)($_POST["task_id"] ?? 0);
    
    // Get project_id
    $q = mysqli_prepare($connect, "SELECT project_id FROM tasks WHERE id=?");
    mysqli_stmt_bind_param($q, "i", $tid);
    mysqli_stmt_execute($q);
    $res = mysqli_stmt_get_result($q);
    $task = mysqli_fetch_assoc($res);
    
    if (!$task) {
        header("Location: tasks.php?error=" . urlencode("Task tidak ditemukan"));
        exit;
    }
    
    $pid = (int)$task["project_id"];
    if (!can_manage_project($connect, $pid, $uid, $role)) {
        http_response_code(403);
        exit("Akses ditolak");
    }
    
    $nama = trim($_POST["nama_tugas"] ?? "");
    $desk = trim($_POST["deskripsi"] ?? "");
    $status = $_POST["status"] ?? "belum";
    $assignee_raw = $_POST["assigned_to"] ?? "";
    
    // Validasi
    if (empty($nama)) {
        header("Location: tasks.php?project={$pid}&error=" . urlencode("Nama tugas wajib diisi"));
        exit;
    }
    
    // Validasi status
    if (!in_array($status, ['belum', 'proses', 'selesai'], true)) {
        $status = 'belum';
    }
    
    $assignee = ($assignee_raw === "") ? NULL : (int)$assignee_raw;
    
    // Validasi assignee jika ada
    if ($assignee !== NULL) {
        $check = mysqli_prepare($connect, "SELECT role, project_manager_id FROM users WHERE id=?");
        mysqli_stmt_bind_param($check, "i", $assignee);
        mysqli_stmt_execute($check);
        $user = mysqli_fetch_assoc(mysqli_stmt_get_result($check));
        
        if (!$user || $user['role'] !== 'team_member') {
            header("Location: tasks.php?project={$pid}&error=" . urlencode("Hanya bisa assign ke Team Member"));
            exit;
        }
        
        // Validasi TM berada di bawah PM yang sama (jika PM yang assign)
        if ($role === 'project_manager') {
            if ((int)$user['project_manager_id'] !== $uid) {
                header("Location: tasks.php?project={$pid}&error=" . urlencode("Team Member tidak berada di bawah PM Anda"));
                exit;
            }
        }
    }
    
    $stmt = mysqli_prepare($connect, "UPDATE tasks SET nama_tugas=?, deskripsi=?, status=?, assigned_to=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "sssii", $nama, $desk, $status, $assignee, $tid);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: tasks.php?project={$pid}&success=" . urlencode("Task berhasil diupdate"));
        exit;
    } else {
        header("Location: tasks.php?project={$pid}&error=" . urlencode("Gagal mengupdate task"));
        exit;
    }
}

// PM/super_admin: DELETE TASK
if (isset($_GET["del"])) {
    $tid = (int)$_GET["del"];
    
    // Get project_id
    $q = mysqli_prepare($connect, "SELECT project_id FROM tasks WHERE id=?");
    mysqli_stmt_bind_param($q, "i", $tid);
    mysqli_stmt_execute($q);
    $res = mysqli_stmt_get_result($q);
    $row = mysqli_fetch_assoc($res);
    
    if (!$row) {
        header("Location: tasks.php?error=" . urlencode("Task tidak ditemukan"));
        exit;
    }
    
    $pid = (int)$row["project_id"];
    
    if (!in_array($role, ["project_manager","super_admin"], true)) {
        http_response_code(403);
        exit("Akses ditolak");
    }
    
    if (!can_manage_project($connect, $pid, $uid, $role)) {
        http_response_code(403);
        exit("Akses ditolak");
    }
    
    $d = mysqli_prepare($connect, "DELETE FROM tasks WHERE id=?");
    mysqli_stmt_bind_param($d, "i", $tid);
    
    if (mysqli_stmt_execute($d)) {
        header("Location: tasks.php?project={$pid}&success=" . urlencode("Task berhasil dihapus"));
        exit;
    } else {
        header("Location: tasks.php?project={$pid}&error=" . urlencode("Gagal menghapus task"));
        exit;
    }
}

// team_member: UPDATE STATUS
if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST["action"] ?? "") === "update_status_member") {
    if ($role !== "team_member") {
        http_response_code(403);
        exit("Akses ditolak");
    }
    
    $tid = (int)($_POST["task_id"] ?? 0);
    $status = $_POST["status"] ?? "belum";
    
    // Validasi status
    if (!in_array($status, ['belum', 'proses', 'selesai'], true)) {
        header("Location: tasks.php?view=my&error=" . urlencode("Status tidak valid"));
        exit;
    }
    
    if (!can_update_task_status($connect, $tid, $uid)) {
        http_response_code(403);
        exit("Task bukan milikmu");
    }
    
    $u = mysqli_prepare($connect, "UPDATE tasks SET status=? WHERE id=?");
    if (!$u) {
        die("Prepare failed: " . mysqli_error($connect));
    }
    
    mysqli_stmt_bind_param($u, "si", $status, $tid);
    
    if (mysqli_stmt_execute($u)) {
        header("Location: tasks.php?view=my&success=" . urlencode("Status berhasil diupdate"));
        exit;
    } else {
        die("Execute failed: " . mysqli_stmt_error($u));
    }
}

$view = $_GET["view"] ?? "";
$project_id = isset($_GET["project"]) ? (int)$_GET["project"] : 0;
$edit_status_id = isset($_GET["edit_status"]) ? (int)$_GET["edit_status"] : 0;
$edit_task_id = isset($_GET["edit"]) ? (int)$_GET["edit"] : 0;

// Get task untuk edit (PM/SA)
$edit_task = null;
if ($edit_task_id > 0 && in_array($role, ["project_manager","super_admin"], true)) {
    $q = mysqli_prepare($connect, "SELECT t.*, p.id as project_id FROM tasks t JOIN projects p ON p.id=t.project_id WHERE t.id=?");
    mysqli_stmt_bind_param($q, "i", $edit_task_id);
    mysqli_stmt_execute($q);
    $edit_task = mysqli_fetch_assoc(mysqli_stmt_get_result($q));
    
    if ($edit_task && !can_manage_project($connect, (int)$edit_task['project_id'], $uid, $role)) {
        $edit_task = null;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasks - Manajemen Proyek</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .gradient-bg { background: linear-gradient(135deg, #9A3412 0%, #451A03 100%); }
    </style>
</head>
<body class="bg-gray-900 text-gray-100">
    <!-- Navbar -->
    <nav class="gradient-bg text-orange-100 p-4 mb-6 shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <a class="text-xl font-bold text-orange-300" href="halaman_utama.php">ProjectManager PRO</a>
            <button id="navbar-toggler" class="md:hidden text-white focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
            </button>
            <div class="hidden md:flex md:items-center md:w-auto w-full" id="navbarNav">
                <ul class="flex flex-col md:flex-row md:ml-auto md:space-x-4 mt-4 md:mt-0">
                    <li>
                        <a class="block py-2 px-4 hover:bg-black/20 rounded-lg transition-colors" href="halaman_utama.php">Dashboard</a>
                    </li>
                    <?php if ($role === "super_admin"): ?>
                        <li>
                            <a class="block py-2 px-4 hover:bg-black/20 rounded-lg transition-colors" href="users.php">Kelola Users</a>
                        </li>
                    <?php endif; ?>
                    <?php if ($role === "project_manager" || $role === "super_admin"): ?>
                        <li>
                            <a class="block py-2 px-4 hover:bg-black/20 rounded-lg transition-colors" href="projects.php">Projects</a>
                        </li>
                        <li>
                            <a class="block py-2 px-4 text-orange-300 bg-black/30 rounded-lg" href="tasks.php">Tasks</a>
                        </li>
                    <?php else: ?>
                        <li>
                            <a class="block py-2 px-4 text-orange-300 bg-black/30 rounded-lg" href="tasks.php?view=my">My Tasks</a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="flex items-center mt-4 md:mt-0 md:ml-6">
                    <span class="text-white mr-3">
                        <i class="bi bi-person-circle text-orange-300"></i> <strong class="text-orange-300"><?= $username ?></strong>
                        <span class="inline-block bg-black/20 text-orange-200 text-xs font-semibold ml-2 px-2.5 py-1 rounded-full"><?= ucwords(str_replace('_', ' ', $role)) ?></span>
                    </span>
                    <a href="logout.php" class="inline-block text-sm px-4 py-2 leading-none border-2 rounded-lg text-orange-300 border-orange-300 hover:border-transparent hover:text-orange-800 hover:bg-orange-300 transition-colors">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4">
        <h2 class="text-2xl font-bold mb-4 text-orange-400"><i class="bi bi-list-task"></i> Tasks</h2>

        <!-- Alert Messages -->
        <?php if (isset($_GET['error'])): ?>
            <div class="alert-container bg-red-900 border-l-4 border-red-700 text-red-300 p-4 mb-4 rounded-r-lg flex justify-between items-center" role="alert">
                <div><i class="bi bi-exclamation-triangle-fill mr-2"></i> <?= htmlspecialchars($_GET['error']) ?></div>
                <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none';">
                    <i class="bi bi-x text-xl"></i>
                </button>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert-container bg-lime-900 border-l-4 border-lime-700 text-lime-300 p-4 mb-4 rounded-r-lg flex justify-between items-center" role="alert">
                <div><i class="bi bi-check-circle-fill mr-2"></i> <?= htmlspecialchars($_GET['success']) ?></div>
                <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none';">
                    <i class="bi bi-x text-xl"></i>
                </button>
            </div>
        <?php endif; ?>

        <?php
        // ==================== MY TASKS (TEAM MEMBER) ====================
        if ($role === "team_member" && $view === "my") :
        ?>
            <div class="bg-gray-800/50 rounded-xl shadow-lg overflow-hidden border border-gray-700">
                <div class="p-6 border-b border-gray-700">
                    <h5 class="text-lg font-semibold text-orange-400"><i class="bi bi-list-check"></i> Tugas Saya</h5>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-700">
                                <tr>
                                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">ID</th>
                                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Nama Tugas</th>
                                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Proyek</th>
                                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Deskripsi</th>
                                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700/50">
                                <?php
                                $stmt = mysqli_prepare($connect, "SELECT t.id, t.nama_tugas, t.deskripsi, t.status, p.nama_proyek
                                                                  FROM tasks t 
                                                                  JOIN projects p ON p.id=t.project_id
                                                                  WHERE t.assigned_to=? 
                                                                  ORDER BY t.id DESC");
                                mysqli_stmt_bind_param($stmt, "i", $uid);
                                mysqli_stmt_execute($stmt);
                                $res = mysqli_stmt_get_result($stmt);
                                
                                while ($t = mysqli_fetch_assoc($res)):
                                    $badge_color = $t['status'] === 'selesai' ? 'bg-green-800 text-green-300' : ($t['status'] === 'proses' ? 'bg-yellow-800 text-yellow-300' : 'bg-gray-700 text-gray-300');
                                ?>
                                <tr class="hover:bg-gray-800 transition-colors duration-200">
                                    <td class="py-4 px-4 text-gray-400"><?= $t['id'] ?></td>
                                    <td class="py-4 px-4 font-bold text-gray-100"><?= htmlspecialchars($t['nama_tugas']) ?></td>
                                    <td class="py-4 px-4 text-gray-300"><?= htmlspecialchars($t['nama_proyek']) ?></td>
                                    <td class="py-4 px-4 text-gray-400 max-w-xs truncate"><?= htmlspecialchars($t['deskripsi'] ?: '-') ?></td>
                                    <td class="py-4 px-4"><span class="text-xs font-semibold mr-2 px-2.5 py-1 rounded-full <?= $badge_color ?>"><?= ucwords($t['status']) ?></span></td>
                                    <td class="py-4 px-4">
                                        <a href="tasks.php?edit_status=<?= $t['id'] ?>" class="bg-orange-700 hover:bg-orange-800 text-orange-100 text-xs font-bold py-2 px-3 rounded-md transition-colors">
                                            <i class="bi bi-pencil"></i> Update Status
                                        </a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        <?php
        // ==================== FORM UPDATE STATUS (TEAM MEMBER) ====================
        elseif ($role === "team_member" && $edit_status_id > 0) :
            if (!can_update_task_status($connect, $edit_status_id, $uid)):
        ?>
                <div class="bg-red-900 border-l-4 border-red-700 text-red-300 p-4 rounded-r-lg mb-4" role="alert">
                    <i class="bi bi-x-circle"></i> Akses ditolak - Task ini bukan milik Anda.
                </div>
                <a href="tasks.php?view=my" class="inline-block mt-4 bg-gray-700 hover:bg-gray-600 text-gray-100 font-bold py-2 px-4 rounded">
                    <i class="bi bi-arrow-left"></i> Kembali ke My Tasks
                </a>
            <?php
            else:
                $g = mysqli_prepare($connect, "SELECT t.nama_tugas, t.deskripsi, t.status, p.nama_proyek 
                                                FROM tasks t JOIN projects p ON p.id=t.project_id 
                                                WHERE t.id=?");
                mysqli_stmt_bind_param($g, "i", $edit_status_id);
                mysqli_stmt_execute($g);
                $rs = mysqli_stmt_get_result($g);
                $tt = mysqli_fetch_assoc($rs);

                if (!$tt):
            ?>
                <div class="bg-red-900 border-l-4 border-red-700 text-red-300 p-4 rounded-r-lg mb-4" role="alert">
                    <i class="bi bi-x-circle"></i> Task tidak ditemukan.
                </div>
                <a href="tasks.php?view=my" class="inline-block mt-4 bg-gray-700 hover:bg-gray-600 text-gray-100 font-bold py-2 px-4 rounded">
                    <i class="bi bi-arrow-left"></i> Kembali ke My Tasks
                </a>
            <?php
                else:
                    $badge_color = $tt['status'] === 'selesai' ? 'bg-green-800 text-green-300' : ($tt['status'] === 'proses' ? 'bg-yellow-800 text-yellow-300' : 'bg-gray-700 text-gray-300');
            ?>
                <div class="bg-gray-800 rounded-xl shadow-lg max-w-lg mx-auto border border-gray-700">
                    <div class="p-4 bg-orange-800 text-orange-200 rounded-t-xl">
                        <h5 class="font-bold text-lg"><i class="bi bi-pencil"></i> Update Status Task</h5>
                    </div>
                    <div class="p-6">
                        <div class="bg-orange-900/50 border-t-4 border-orange-600 rounded-b text-orange-300 px-4 py-3 shadow-md mb-4" role="alert">
                            <strong>Nama Task:</strong> <?= htmlspecialchars($tt["nama_tugas"]) ?><br>
                            <strong>Proyek:</strong> <?= htmlspecialchars($tt["nama_proyek"]) ?><br>
                            <strong>Deskripsi:</strong> <?= htmlspecialchars($tt["deskripsi"] ?: '-') ?>
                        </div>
                        
                        <form method="post">
                            <input type="hidden" name="action" value="update_status_member">
                            <input type="hidden" name="task_id" value="<?= $edit_status_id ?>">
                            
                            <div class="mb-4">
                                <label class="block text-gray-300 text-sm font-bold mb-2"><strong>Status Saat Ini:</strong> 
                                    <span class="text-xs font-semibold ml-2 px-2.5 py-1 rounded-full <?= $badge_color ?>">
                                        <?= $tt['status'] ?>
                                    </span>
                                </label>
                            </div>
                            
                            <div class="mb-6">
                                <label class="block text-gray-300 text-sm font-bold mb-2">Ubah Status Ke: <span class="text-red-500">*</span></label>
                                <select name="status" class="shadow appearance-none border rounded w-full py-3 px-4 bg-gray-700 border-gray-600 text-gray-100 leading-tight focus:outline-none focus:shadow-outline focus:ring-orange-500 text-lg" required>
                                    <option value="belum" <?= $tt['status']==='belum' ? 'selected' : '' ?>>🔴 Belum Dikerjakan</option>
                                    <option value="proses" <?= $tt['status']==='proses' ? 'selected' : '' ?>>🟡 Sedang Proses</option>
                                    <option value="selesai" <?= $tt['status']==='selesai' ? 'selected' : '' ?>>🟢 Selesai</option>
                                </select>
                            </div>
                            
                            <div class="space-y-2 text-gray-100">
                                <button type="submit" class="w-full bg-orange-700 hover:bg-orange-800 text-orange-100 font-bold py-3 px-4 rounded-lg text-lg">
                                    <i class="bi bi-save"></i> Simpan Status
                                </button>
                                <a href="tasks.php?view=my" class="block text-center w-full bg-gray-700 hover:bg-gray-600 text-gray-100 font-bold py-2 px-4 rounded">
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            <?php
                endif;
            endif;
        endif;

        // ==================== TASKS PER PROJECT (PM/SA) ====================
        if ($project_id > 0 && ($role === "project_manager" || $role === "super_admin")) :
            if (!can_manage_project($connect, $project_id, $uid, $role) && $role !== "super_admin"):
        ?>
                <div class="bg-red-900 border-l-4 border-red-700 text-red-300 p-4 rounded-r-lg mb-4" role="alert">Akses ditolak.</div>
            <?php
            else:
                $p = mysqli_prepare($connect, "SELECT nama_proyek FROM projects WHERE id=?");
                mysqli_stmt_bind_param($p, "i", $project_id);
                mysqli_stmt_execute($p);
                $r = mysqli_stmt_get_result($p);
                $proj = mysqli_fetch_assoc($r);
            ?>
                <div class="mb-4">
                    <a href="projects.php" class="inline-block bg-gray-700 hover:bg-gray-600 text-gray-100 font-bold py-2 px-4 rounded">
                        <i class="bi bi-arrow-left"></i> Kembali ke Projects
                    </a>
                </div>

                <div class="flex flex-wrap -mx-4">
                    <!-- Form Create/Edit Task -->
                    <div class="w-full md:w-1/3 px-4 mb-6">
                        <div class="bg-gray-800 rounded-xl shadow-lg border border-gray-700">
                            <div class="p-4 bg-orange-800 text-orange-200 rounded-t-xl">
                                <h5 class="font-bold text-lg">
                                    <i class="bi bi-<?= $edit_task ? 'pencil' : 'plus-circle' ?>"></i> 
                                    <?= $edit_task ? 'Edit Task' : 'Buat Task Baru' ?>
                                </h5>
                            </div>
                            <div class="p-6">
                                <div class="bg-orange-900/50 text-orange-300 px-4 py-3 rounded relative mb-4" role="alert">
                                    <strong>Proyek:</strong> <?= htmlspecialchars($proj["nama_proyek"] ?? "Unknown") ?>
                                </div>
                                
                                <form method="post">
                                    <input type="hidden" name="action" value="<?= $edit_task ? 'edit' : 'create' ?>">
                                    <input type="hidden" name="project_id" value="<?= $project_id ?>">
                                    <?php if ($edit_task): ?>
                                        <input type="hidden" name="task_id" value="<?= $edit_task['id'] ?>">
                                    <?php endif; ?>
                                    
                                    <div class="mb-4">
                                        <label class="block text-gray-300 text-sm font-bold mb-2">Nama Task <span class="text-red-500">*</span></label>
                                        <input type="text" class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 transition-all" name="nama_tugas" 
                                               value="<?= $edit_task ? htmlspecialchars($edit_task['nama_tugas']) : '' ?>" required>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label class="block text-gray-300 text-sm font-bold mb-2">Deskripsi</label>
                                        <textarea class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 transition-all" name="deskripsi" rows="3"><?= $edit_task ? htmlspecialchars($edit_task['deskripsi']) : '' ?></textarea>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label class="block text-gray-300 text-sm font-bold mb-2">Status <span class="text-red-500">*</span></label>
                                        <select name="status" class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 transition-all" required>
                                            <option value="belum" <?= ($edit_task && $edit_task['status']==='belum') ? 'selected' : '' ?>>Belum</option>
                                            <option value="proses" <?= ($edit_task && $edit_task['status']==='proses') ? 'selected' : '' ?>>Proses</option>
                                            <option value="selesai" <?= ($edit_task && $edit_task['status']==='selesai') ? 'selected' : '' ?>>Selesai</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-6">
                                        <label class="block text-gray-300 text-sm font-bold mb-2">Assign ke</label>
                                        <select name="assigned_to" class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 transition-all">
                                            <option value="">- Tidak ada -</option>
                                            <?php
                                            // Jika PM, hanya tampilkan TM yang berada di bawahnya
                                            if ($role === 'project_manager') {
                                                $us = mysqli_prepare($connect, "SELECT id, username FROM users WHERE role='team_member' AND project_manager_id=? ORDER BY username");
                                                mysqli_stmt_bind_param($us, "i", $uid);
                                                mysqli_stmt_execute($us); // Fix: execute the statement
                                                $us_res = mysqli_stmt_get_result($us);
                                            } else {
                                                // SA bisa assign ke semua TM
                                                $us_res = mysqli_query($connect, "SELECT id, username FROM users WHERE role='team_member' ORDER BY username");
                                            }
                                            
                                            while ($u = mysqli_fetch_assoc($us_res)):
                                            ?>
                                                <option value="<?= $u['id'] ?>" <?= ($edit_task && $edit_task['assigned_to']==$u['id']) ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($u['username']) ?>
                                                </option>
                                            <?php endwhile; ?>
                                        </select>
                                        <small class="text-gray-500 text-xs mt-1">Opsional - hanya Team Member</small>
                                    </div>
                                    
                                    <button type="submit" class="w-full bg-orange-700 text-orange-100 font-bold py-3 px-4 rounded-lg hover:bg-orange-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all transform hover:-translate-y-1">
                                        <i class="bi bi-save-fill mr-1"></i> <?= $edit_task ? 'Update' : 'Simpan' ?>
                                    </button>
                                    
                                    <?php if ($edit_task): ?>
                                        <a href="tasks.php?project=<?= $project_id ?>" class="block text-center bg-gray-700 hover:bg-gray-600 text-gray-100 font-bold py-2 px-4 rounded w-full mt-2">
                                            <i class="bi bi-x-circle"></i> Batal
                                        </a>
                                    <?php endif; ?>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Daftar Tasks -->
                    <div class="w-full md:w-2/3 px-4">
                        <div class="bg-gray-800/50 rounded-xl shadow-lg overflow-hidden border border-gray-700">
                            <div class="p-6 border-b border-gray-700">
                                <h5 class="text-lg font-semibold text-orange-400"><i class="bi bi-list-ul"></i> Daftar Tasks</h5>
                            </div>
                            <div class="p-6">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full">
                                        <thead class="bg-gray-700">
                                            <tr>
                                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">ID</th>
                                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Nama Task</th>
                                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Assignee</th>
                                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-700/50">
                                            <?php
                                            $stmt = mysqli_prepare($connect, "SELECT t.id, t.nama_tugas, t.status, u.username AS assignee
                                                                              FROM tasks t 
                                                                              LEFT JOIN users u ON u.id=t.assigned_to
                                                                              WHERE t.project_id=? 
                                                                              ORDER BY t.id DESC");
                                            mysqli_stmt_bind_param($stmt, "i", $project_id);
                                            mysqli_stmt_execute($stmt);
                                            $res = mysqli_stmt_get_result($stmt);
                                            
                                            while ($t = mysqli_fetch_assoc($res)):
                                                $badge_color = $t['status'] === 'selesai' ? 'bg-green-800 text-green-300' : ($t['status'] === 'proses' ? 'bg-yellow-800 text-yellow-300' : 'bg-gray-700 text-gray-300');
                                            ?>
                                            <tr class="hover:bg-gray-800 transition-colors duration-200">
                                                <td class="py-4 px-4 text-gray-400"><?= $t['id'] ?></td>
                                                <td class="py-4 px-4 font-bold text-gray-100"><?= htmlspecialchars($t['nama_tugas']) ?></td>
                                                <td class="py-4 px-4"><span class="text-xs font-semibold mr-2 px-2.5 py-1 rounded-full <?= $badge_color ?>"><?= ucwords($t['status']) ?></span></td>
                                                <td class="py-4 px-4">
                                                    <?php if ($t['assignee']): ?>
                                                        <span class="bg-gray-700 text-gray-300 text-xs font-semibold mr-2 px-2.5 py-1 rounded-full"><?= htmlspecialchars($t['assignee']) ?></span>
                                                    <?php else: ?>
                                                        <span class="text-gray-500">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="py-4 px-4 whitespace-nowrap">
                                                    <a href="tasks.php?project=<?= $project_id ?>&edit=<?= $t['id'] ?>" class="bg-yellow-600 hover:bg-yellow-700 text-white text-xs font-bold py-2 px-3 rounded-md transition-colors">
                                                        <i class="bi bi-pencil"></i> Edit
                                                    </a>
                                                    <a href="tasks.php?del=<?= $t['id'] ?>"
                                                       class="bg-red-700 hover:bg-red-800 text-red-200 text-xs font-bold py-2 px-3 rounded-md transition-colors ml-1"
                                                       onclick="return confirm('Yakin hapus task ini?')">
                                                        <i class="bi bi-trash"></i> Hapus
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            endif;
        endif;

        // ==================== DEFAULT VIEW ====================
        if ($role === "team_member" && !$view && !$edit_status_id) :
        ?>
            <div class="bg-orange-900/50 border-l-4 border-orange-600 text-orange-300 p-4 rounded-r-lg mb-4" role="alert">
                <i class="bi bi-info-circle"></i> 
                Buka <a href="tasks.php?view=my" class="font-bold underline">My Tasks</a> untuk melihat tugasmu.
            </div>
        <?php
        endif;

        if (($role === "project_manager" || $role === "super_admin") && !$project_id && !$edit_task_id) :
        ?>
            <div class="bg-orange-900/50 border-l-4 border-orange-600 text-orange-300 p-4 rounded-r-lg mb-4" role="alert">
                <i class="bi bi-info-circle"></i> 
                Pilih proyek dari halaman <a href="projects.php" class="font-bold underline">Projects</a> untuk mengelola tasks.
            </div>
        <?php
        endif;
        ?>
    </div>

    <script>
        // Navbar Toggle
        document.getElementById('navbar-toggler').addEventListener('click', function() {
            var menu = document.getElementById('navbarNav');
            menu.classList.toggle('hidden');
        });
    </script>
</body>
</html>