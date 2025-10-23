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

if (!in_array($_SESSION["role"], ["project_manager","super_admin"], true)) {
    http_response_code(403);
    exit("Akses ditolak");
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

// CREATE
if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST["action"] ?? "") === "create") {
    $nama = trim($_POST["nama_proyek"] ?? "");
    $desk = trim($_POST["deskripsi"] ?? "");
    $mulai = $_POST["tanggal_mulai"] ?? "";
    $selesai = $_POST["tanggal_selesai"] ?? "";
    
    // Validasi
    if (empty($nama) || empty($mulai)) {
        header("Location: projects.php?error=" . urlencode("Nama proyek dan tanggal mulai wajib diisi"));
        exit;
    }
    
    // Validasi tanggal
    if (!empty($selesai) && $selesai < $mulai) {
        header("Location: projects.php?error=" . urlencode("Tanggal selesai tidak boleh lebih awal dari tanggal mulai"));
        exit;
    }
    
    $mulai_val = $mulai ?: NULL;
    $selesai_val = $selesai ?: NULL;
    
    if ($role === "project_manager") {
        $manager_id = $uid;
    } else {
        $manager_id = (int)($_POST["manager_id"] ?? 0);
        $chk = mysqli_prepare($connect, "SELECT 1 FROM users WHERE id=? AND role='project_manager'");
        mysqli_stmt_bind_param($chk, "i", $manager_id);
        mysqli_stmt_execute($chk);
        $ok = mysqli_fetch_row(mysqli_stmt_get_result($chk));
        if (!$ok) {
            header("Location: projects.php?error=" . urlencode("Manager ID bukan PM yang valid"));
            exit;
        }
    }
    
    $stmt = mysqli_prepare($connect, "INSERT INTO projects (nama_proyek, deskripsi, tanggal_mulai, tanggal_selesai, manager_id)
                                      VALUES (?,?,?,?,?)");
    mysqli_stmt_bind_param($stmt, "ssssi", $nama, $desk, $mulai_val, $selesai_val, $manager_id);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: projects.php?success=" . urlencode("Proyek berhasil ditambahkan"));
        exit;
    } else {
        header("Location: projects.php?error=" . urlencode("Gagal menambahkan proyek"));
        exit;
    }
}

// UPDATE/EDIT
if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST["action"] ?? "") === "edit") {
    $pid = (int)($_POST["project_id"] ?? 0);
    
    if (!can_manage_project($connect, $pid, $uid, $role)) {
        http_response_code(403);
        exit("Akses ditolak");
    }
    
    $nama = trim($_POST["nama_proyek"] ?? "");
    $desk = trim($_POST["deskripsi"] ?? "");
    $mulai = $_POST["tanggal_mulai"] ?? "";
    $selesai = $_POST["tanggal_selesai"] ?? "";
    
    // Validasi
    if (empty($nama) || empty($mulai)) {
        header("Location: projects.php?error=" . urlencode("Nama proyek dan tanggal mulai wajib diisi"));
        exit;
    }
    
    // Validasi tanggal
    if (!empty($selesai) && $selesai < $mulai) {
        header("Location: projects.php?error=" . urlencode("Tanggal selesai tidak boleh lebih awal dari tanggal mulai"));
        exit;
    }
    
    $mulai_val = $mulai ?: NULL;
    $selesai_val = $selesai ?: NULL;
    
    $stmt = mysqli_prepare($connect, "UPDATE projects SET nama_proyek=?, deskripsi=?, tanggal_mulai=?, tanggal_selesai=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "ssssi", $nama, $desk, $mulai_val, $selesai_val, $pid);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: projects.php?success=" . urlencode("Proyek berhasil diupdate"));
        exit;
    } else {
        header("Location: projects.php?error=" . urlencode("Gagal mengupdate proyek"));
        exit;
    }
}

// DELETE
if (isset($_GET["del"])) {
    $pid = (int)$_GET["del"];
    if (!can_manage_project($connect, $pid, $uid, $role)) {
        http_response_code(403);
        exit("Akses ditolak");
    }
    
    $d = mysqli_prepare($connect, "DELETE FROM projects WHERE id=?");
    mysqli_stmt_bind_param($d, "i", $pid);
    
    if (mysqli_stmt_execute($d)) {
        header("Location: projects.php?success=" . urlencode("Proyek berhasil dihapus"));
        exit;
    } else {
        header("Location: projects.php?error=" . urlencode("Gagal menghapus proyek"));
        exit;
    }
}

// Get project untuk edit
$edit_project = null;
if (isset($_GET["edit"])) {
    $edit_id = (int)$_GET["edit"];
    if (can_manage_project($connect, $edit_id, $uid, $role)) {
        $stmt = mysqli_prepare($connect, "SELECT * FROM projects WHERE id=?");
        mysqli_stmt_bind_param($stmt, "i", $edit_id);
        mysqli_stmt_execute($stmt);
        $edit_project = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects - Manajemen Proyek</title>
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
                    <li>
                        <a class="block py-2 px-4 text-orange-300 bg-black/30 rounded-lg" href="projects.php">Projects</a>
                    </li>
                    <li>
                        <a class="block py-2 px-4 hover:bg-black/20 rounded-lg transition-colors" href="tasks.php">Tasks</a>
                    </li>
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

    <div class="container mx-auto px-4 text-gray-100">
        <h2 class="text-2xl font-bold mb-4 text-orange-400"><i class="bi bi-folder-fill"></i> Projects</h2>

        <!-- Alert Messages -->
        <?php if (isset($_GET['error'])): ?>
            <div class="alert-container bg-red-900 border border-red-700 text-red-300 px-4 py-3 rounded relative mb-4" role="alert">
                <i class="bi bi-exclamation-triangle"></i> <?= htmlspecialchars($_GET['error']) ?>
                <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none';">
                    <span class="text-red-400">×</span>
                </button>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert-container bg-lime-900 border border-lime-700 text-lime-300 px-4 py-3 rounded relative mb-4" role="alert">
                <i class="bi bi-check-circle"></i> <?= htmlspecialchars($_GET['success']) ?>
                <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none';">
                    <span class="text-lime-400">×</span>
                </button>
            </div>
        <?php endif; ?>

        <div class="flex flex-wrap -mx-4">
            <!-- Form Create/Edit -->
            <div class="w-full md:w-1/3 px-4 mb-6 text-gray-100">
                <div class="bg-gray-800 rounded-xl shadow-lg border border-gray-700">
                    <div class="p-4 bg-orange-800 text-orange-200 rounded-t-xl">
                        <h5 class="font-bold text-lg">
                            <i class="bi bi-<?= $edit_project ? 'pencil' : 'plus-circle' ?>"></i> 
                            <?= $edit_project ? 'Edit Proyek' : 'Buat Proyek Baru' ?>
                        </h5>
                    </div>
                    <div class="p-6">
                        <form method="post">
                            <input type="hidden" name="action" value="<?= $edit_project ? 'edit' : 'create' ?>">
                            <?php if ($edit_project): ?>
                                <input type="hidden" name="project_id" value="<?= $edit_project['id'] ?>">
                            <?php endif; ?>
                            
                            <div class="mb-4">
                                <label class="block text-gray-300 text-sm font-bold mb-2">Nama Proyek <span class="text-red-500">*</span></label>
                                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 bg-gray-700 border-gray-600 text-gray-100 leading-tight focus:outline-none focus:shadow-outline focus:ring-orange-500" name="nama_proyek" 
                                       value="<?= $edit_project ? htmlspecialchars($edit_project['nama_proyek']) : '' ?>" required>
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-gray-300 text-sm font-bold mb-2">Deskripsi</label>
                                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 bg-gray-700 border-gray-600 text-gray-100 leading-tight focus:outline-none focus:shadow-outline focus:ring-orange-500" name="deskripsi" rows="3"><?= $edit_project ? htmlspecialchars($edit_project['deskripsi']) : '' ?></textarea>
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-gray-300 text-sm font-bold mb-2">Tanggal Mulai <span class="text-red-500">*</span></label>
                                <input type="date" class="shadow appearance-none border rounded w-full py-2 px-3 bg-gray-700 border-gray-600 text-gray-100 leading-tight focus:outline-none focus:shadow-outline focus:ring-orange-500" name="tanggal_mulai" 
                                       value="<?= $edit_project ? $edit_project['tanggal_mulai'] : '' ?>" required>
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-gray-300 text-sm font-bold mb-2">Tanggal Selesai</label>
                                <input type="date" class="shadow appearance-none border rounded w-full py-2 px-3 bg-gray-700 border-gray-600 text-gray-100 leading-tight focus:outline-none focus:shadow-outline focus:ring-orange-500" name="tanggal_selesai" 
                                       value="<?= $edit_project ? $edit_project['tanggal_selesai'] : '' ?>">
                                <small class="text-gray-400 text-xs">Opsional</small>
                            </div>
                            
                            <?php if ($role === "super_admin" && !$edit_project): ?>
                                <div class="mb-4">
                                    <label class="block text-gray-300 text-sm font-bold mb-2">Manager (PM) <span class="text-red-500">*</span></label>
                                    <select name="manager_id" class="shadow appearance-none border rounded w-full py-2 px-3 bg-gray-700 border-gray-600 text-gray-100 leading-tight focus:outline-none focus:shadow-outline focus:ring-orange-500" required>
                                        <option value="">-- Pilih PM --</option>
                                        <?php
                                        $pm = mysqli_query($connect, "SELECT id, username FROM users WHERE role='project_manager' ORDER BY username");
                                        while ($r = mysqli_fetch_assoc($pm)):
                                        ?>
                                            <option value="<?= $r['id'] ?>"><?= htmlspecialchars($r['username']) ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            <?php endif; ?>
                            
                            <button type="submit" class="bg-orange-700 hover:bg-orange-800 text-orange-100 font-bold py-2 px-4 rounded w-full">
                                <i class="bi bi-save"></i> <?= $edit_project ? 'Update' : 'Simpan' ?>
                            </button>
                            
                            <?php if ($edit_project): ?> 
                                <a href="projects.php" class="block text-center bg-gray-700 hover:bg-gray-600 text-gray-100 font-bold py-2 px-4 rounded w-full mt-2">
                                    <i class="bi bi-x-circle"></i> Batal
                                </a>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Daftar Projects -->
            <div class="w-full md:w-2/3 px-4 text-gray-100">
                <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-700">
                    <div class="p-6 border-b border-gray-700">
                        <h5 class="text-lg font-semibold text-orange-400"><i class="bi bi-list-ul"></i> Daftar Proyek</h5>
                    </div>
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-gray-800">
                                <thead class="bg-gray-700">
                                    <tr>
                                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">ID</th>
                                        <?php if ($role === "super_admin"): ?>
                                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Manager</th>
                                        <?php endif; ?>
                                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Nama Proyek</th>
                                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Tanggal Mulai</th>
                                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Tanggal Selesai</th>
                                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-700">
                                    <?php
                                    if ($role === "project_manager") {
                                        $stmt = mysqli_prepare($connect, "SELECT id, nama_proyek, tanggal_mulai, COALESCE(tanggal_selesai,'-') AS tsel 
                                                                          FROM projects WHERE manager_id=? ORDER BY id DESC");
                                        mysqli_stmt_bind_param($stmt, "i", $uid);
                                        mysqli_stmt_execute($stmt);
                                        $res = mysqli_stmt_get_result($stmt);
                                    } else {
                                        $res = mysqli_query($connect, "SELECT p.id, p.nama_proyek, p.tanggal_mulai, COALESCE(p.tanggal_selesai,'-') AS tsel, u.username AS manager
                                                                       FROM projects p 
                                                                       JOIN users u ON u.id=p.manager_id 
                                                                       ORDER BY p.id DESC");
                                    }
                                    
                                    while ($p = mysqli_fetch_assoc($res)):
                                    ?>
                                    <tr class="hover:bg-gray-700">
                                        <td class="py-2 px-4 border-b border-gray-700 text-gray-300"><?= $p['id'] ?></td>
                                        <?php if ($role === "super_admin"): ?>
                                            <td class="py-2 px-4 border-b border-gray-700"><span class="bg-orange-800 text-orange-200 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded"><?= htmlspecialchars($p['manager']) ?></span></td>
                                        <?php endif; ?>
                                        <td class="py-2 px-4 border-b border-gray-700 font-bold text-gray-100"><?= htmlspecialchars($p['nama_proyek']) ?></td>
                                        <td class="py-2 px-4 border-b border-gray-700 text-gray-300"><?= $p['tanggal_mulai'] ?></td>
                                        <td class="py-2 px-4 border-b border-gray-700 text-gray-300"><?= $p['tsel'] ?></td>
                                        <td class="py-2 px-4 border-b border-gray-700 whitespace-nowrap">
                                            <a href="tasks.php?project=<?= $p['id'] ?>" class="bg-orange-700 hover:bg-orange-800 text-orange-100 text-sm font-bold py-1 px-2 rounded">
                                                <i class="bi bi-list-check"></i> Tasks
                                            </a>
                                            <?php if (can_manage_project($connect, (int)$p["id"], $uid, $role)): ?>
                                                <a href="projects.php?edit=<?= $p['id'] ?>" class="bg-yellow-600 hover:bg-yellow-700 text-white text-sm font-bold py-1 px-2 rounded ml-1">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </a>
                                                <a href="projects.php?del=<?= $p['id'] ?>"
                                                   class="bg-red-700 hover:bg-red-800 text-red-200 text-sm font-bold py-1 px-2 rounded ml-1"
                                                   onclick="return confirm('Yakin hapus proyek ini? Semua tasks akan terhapus!')">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </a>
                                            <?php endif; ?>
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