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

if ($_SESSION["role"] !== "super_admin") {
    http_response_code(403);
    exit("Akses ditolak - Hanya Super Admin");
}

require "connect.php";

$username = htmlspecialchars($_SESSION["username"]);

// CREATE USER
if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST["action"] ?? "") === "create") {
    $new_username = trim($_POST["username"] ?? "");
    $new_password = $_POST["password"] ?? "";
    $new_role = $_POST["role"] ?? "";
    $pm_id = $_POST["project_manager_id"] ?? "";
    
    // Validasi
    if (empty($new_username) || empty($new_password) || empty($new_role)) {
        header("Location: users.php?error=" . urlencode("Semua field wajib diisi"));
        exit;
    }
    
    if (!in_array($new_role, ["project_manager", "team_member"], true)) {
        header("Location: users.php?error=" . urlencode("Role tidak valid"));
        exit;
    }
    
    // Validasi username unique
    $check = mysqli_prepare($connect, "SELECT id FROM users WHERE username = ?");
    mysqli_stmt_bind_param($check, "s", $new_username);
    mysqli_stmt_execute($check);
    if (mysqli_fetch_row(mysqli_stmt_get_result($check))) {
        header("Location: users.php?error=" . urlencode("Username sudah digunakan"));
        exit;
    }
    
    // Hash password
    $hashed = password_hash($new_password, PASSWORD_BCRYPT);
    
    // Jika team_member, wajib ada PM
    if ($new_role === "team_member") {
        $pm_id_int = (int)$pm_id;
        if ($pm_id_int <= 0) {
            header("Location: users.php?error=" . urlencode("Team Member harus memiliki Project Manager"));
            exit;
        }
        
        // Validasi PM exist
        $check_pm = mysqli_prepare($connect, "SELECT id FROM users WHERE id = ? AND role = 'project_manager'");
        mysqli_stmt_bind_param($check_pm, "i", $pm_id_int);
        mysqli_stmt_execute($check_pm);
        if (!mysqli_fetch_row(mysqli_stmt_get_result($check_pm))) {
            header("Location: users.php?error=" . urlencode("Project Manager tidak valid"));
            exit;
        }
        
        $stmt = mysqli_prepare($connect, "INSERT INTO users (username, password, role, project_manager_id) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sssi", $new_username, $hashed, $new_role, $pm_id_int);
    } else {
        // Project Manager tidak perlu PM
        $stmt = mysqli_prepare($connect, "INSERT INTO users (username, password, role, project_manager_id) VALUES (?, ?, ?, NULL)");
        mysqli_stmt_bind_param($stmt, "sss", $new_username, $hashed, $new_role);
    }
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: users.php?success=" . urlencode("User berhasil ditambahkan"));
        exit;
    } else {
        header("Location: users.php?error=" . urlencode("Gagal menambahkan user"));
        exit;
    }
}

// DELETE USER
if (isset($_GET["del"])) {
    $del_id = (int)$_GET["del"];
    
    // Tidak bisa hapus diri sendiri
    if ($del_id === (int)$_SESSION["user_id"]) {
        header("Location: users.php?error=" . urlencode("Tidak bisa menghapus akun sendiri"));
        exit;
    }
    
    // Cek apakah user ada dan bukan super_admin
    $check = mysqli_prepare($connect, "SELECT role FROM users WHERE id = ?");
    mysqli_stmt_bind_param($check, "i", $del_id);
    mysqli_stmt_execute($check);
    $res = mysqli_stmt_get_result($check);
    $user = mysqli_fetch_assoc($res);
    
    if (!$user) {
        header("Location: users.php?error=" . urlencode("User tidak ditemukan"));
        exit;
    }
    
    if ($user["role"] === "super_admin") {
        header("Location: users.php?error=" . urlencode("Tidak bisa menghapus Super Admin"));
        exit;
    }
    
    // Cek apakah PM masih punya proyek
    if ($user["role"] === "project_manager") {
        $check_proj = mysqli_prepare($connect, "SELECT COUNT(*) as cnt FROM projects WHERE manager_id = ?");
        mysqli_stmt_bind_param($check_proj, "i", $del_id);
        mysqli_stmt_execute($check_proj);
        $cnt = mysqli_fetch_assoc(mysqli_stmt_get_result($check_proj));
        if ($cnt["cnt"] > 0) {
            header("Location: users.php?error=" . urlencode("Tidak bisa hapus PM yang masih memiliki proyek aktif"));
            exit;
        }
    }
    
    // Hapus user
    $del_stmt = mysqli_prepare($connect, "DELETE FROM users WHERE id = ?");
    mysqli_stmt_bind_param($del_stmt, "i", $del_id);
    
    if (mysqli_stmt_execute($del_stmt)) {
        header("Location: users.php?success=" . urlencode("User berhasil dihapus"));
        exit;
    } else {
        header("Location: users.php?error=" . urlencode("Gagal menghapus user"));
        exit;
    }
}

// EDIT USER (Update PM untuk TM)
if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST["action"] ?? "") === "edit") {
    $edit_id = (int)($_POST["user_id"] ?? 0);
    $new_pm_id = (int)($_POST["project_manager_id"] ?? 0);
    
    // Validasi user adalah team_member
    $check = mysqli_prepare($connect, "SELECT role FROM users WHERE id = ?");
    mysqli_stmt_bind_param($check, "i", $edit_id);
    mysqli_stmt_execute($check);
    $user = mysqli_fetch_assoc(mysqli_stmt_get_result($check));
    
    if (!$user || $user["role"] !== "team_member") {
        header("Location: users.php?error=" . urlencode("Hanya bisa edit Team Member"));
        exit;
    }
    
    // Validasi PM
    $check_pm = mysqli_prepare($connect, "SELECT id FROM users WHERE id = ? AND role = 'project_manager'");
    mysqli_stmt_bind_param($check_pm, "i", $new_pm_id);
    mysqli_stmt_execute($check_pm);
    if (!mysqli_fetch_row(mysqli_stmt_get_result($check_pm))) {
        header("Location: users.php?error=" . urlencode("Project Manager tidak valid"));
        exit;
    }
    
    // Update
    $upd = mysqli_prepare($connect, "UPDATE users SET project_manager_id = ? WHERE id = ?");
    mysqli_stmt_bind_param($upd, "ii", $new_pm_id, $edit_id);
    
    if (mysqli_stmt_execute($upd)) {
        header("Location: users.php?success=" . urlencode("Project Manager berhasil diupdate"));
        exit;
    } else {
        header("Location: users.php?error=" . urlencode("Gagal update user"));
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Users - Manajemen Proyek</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #9A3412 0%, #451A03 100%); }
        .modal { transition: opacity 0.25s ease; }
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
                    <li class="my-1 md:my-0">
                        <a class="block py-2 px-4 hover:bg-black/20 rounded-lg transition-colors" href="halaman_utama.php">Dashboard</a>
                    </li>
                    <li class="my-1 md:my-0">
                        <a class="block py-2 px-4 text-orange-300 bg-black/30 rounded-lg" href="users.php">Kelola Users</a>
                    </li>
                    <li class="my-1 md:my-0">
                        <a class="block py-2 px-4 hover:bg-black/20 rounded-lg transition-colors" href="projects.php">Projects</a>
                    </li>
                    <li class="my-1 md:my-0">
                        <a class="block py-2 px-4 hover:bg-black/20 rounded-lg transition-colors" href="tasks.php">Tasks</a>
                    </li>
                </ul>
                <div class="flex items-center mt-4 md:mt-0 md:ml-6">
                    <span class="text-white mr-3">
                        <i class="bi bi-person-circle text-orange-300"></i> <strong class="text-orange-300"><?= $username ?></strong>
                        <span class="inline-block bg-black/20 text-orange-200 text-xs font-semibold ml-2 px-2.5 py-1 rounded-full">Super Admin</span>
                    </span>
                    <a href="logout.php" class="inline-block text-sm px-4 py-2 leading-none border-2 rounded-lg text-orange-300 border-orange-300 hover:border-transparent hover:text-orange-800 hover:bg-orange-300 transition-colors">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-orange-400 mb-6"><i class="bi bi-people-fill mr-2"></i>Kelola Users</h1>

        <!-- Alert Messages -->
        <?php if (isset($_GET['error'])): ?>
            <div class="alert-container bg-red-900 border-l-4 border-red-700 text-red-300 p-4 mb-4 rounded-r-lg flex justify-between items-center" role="alert">
                <div><i class="bi bi-exclamation-triangle-fill mr-2"></i> <?= htmlspecialchars($_GET['error']) ?></div>
                <button type="button" onclick="this.parentElement.style.display='none';">
                    <i class="bi bi-x text-xl"></i>
                </button>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert-container bg-lime-900 border-l-4 border-lime-700 text-lime-300 p-4 mb-4 rounded-r-lg flex justify-between items-center" role="alert">
                <div><i class="bi bi-check-circle-fill mr-2"></i> <?= htmlspecialchars($_GET['success']) ?></div>
                <button type="button" onclick="this.parentElement.style.display='none';">
                    <i class="bi bi-x text-xl"></i>
                </button>
            </div>
        <?php endif; ?>

        <div class="flex flex-wrap -mx-4">
            <!-- Form Tambah User -->
            <div class="w-full lg:w-1/3 px-4 mb-6">
                <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-700">
                    <div class="p-6 bg-orange-800 text-orange-200">
                        <h2 class="font-bold text-xl"><i class="bi bi-person-plus-fill mr-2"></i>Tambah User Baru</h2>
                    </div>
                    <div class="p-6">
                        <form method="post" id="formTambah">
                            <input type="hidden" name="action" value="create">
                            
                            <div class="mb-4">
                                <label class="block text-gray-300 text-sm font-bold mb-2">Username <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 transition-all" name="username" required>
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-gray-300 text-sm font-bold mb-2">Password <span class="text-red-500">*</span></label>
                                <input type="password" class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 transition-all" name="password" required minlength="6">
                                <small class="text-gray-500 text-xs mt-1">Min. 6 karakter</small>
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-gray-300 text-sm font-bold mb-2">Role <span class="text-red-500">*</span></label>
                                <select class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 transition-all" name="role" id="roleSelect" required>
                                    <option value="">-- Pilih Role --</option>
                                    <option value="project_manager">Project Manager</option>
                                    <option value="team_member">Team Member</option>
                                </select>
                            </div>
                            
                            <div class="mb-6" id="pmSelectDiv" style="display:none;">
                                <label class="block text-gray-300 text-sm font-bold mb-2">Project Manager <span class="text-red-500">*</span></label>
                                <select class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 transition-all" name="project_manager_id" id="pmSelect">
                                    <option value="">-- Pilih PM --</option>
                                    <?php
                                    $pm_list = mysqli_query($connect, "SELECT id, username FROM users WHERE role='project_manager' ORDER BY username");
                                    while ($pm = mysqli_fetch_assoc($pm_list)):
                                    ?>
                                        <option value="<?= $pm['id'] ?>"><?= htmlspecialchars($pm['username']) ?></option>
                                    <?php endwhile; ?>
                                </select>
                                <small class="text-gray-500 text-xs mt-1">Wajib untuk Team Member</small>
                            </div>
                            
                            <button type="submit" class="w-full bg-orange-700 text-orange-100 font-bold py-3 px-4 rounded-lg hover:bg-orange-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all transform hover:-translate-y-1">
                                <i class="bi bi-save-fill mr-1"></i> Simpan User
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Daftar Users -->
            <div class="w-full lg:w-2/3 px-4">
                <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-700">
                    <div class="p-6 border-b border-gray-700">
                        <h2 class="text-xl font-semibold text-orange-400"><i class="bi bi-list-ul mr-2"></i>Daftar Users</h2>
                    </div>
                    <div class="p-4">
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-gray-800">
                                <thead class="bg-gray-700">
                                    <tr>
                                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">ID</th>
                                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Username</th>
                                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Role</th>
                                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Project Manager</th>
                                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-700">
                                    <?php
                                    $users = mysqli_query($connect, "SELECT u.id, u.username, u.role, u.project_manager_id, pm.username AS pm_name
                                                                    FROM users u
                                                                    LEFT JOIN users pm ON pm.id = u.project_manager_id
                                                                    ORDER BY 
                                                                        CASE u.role
                                                                            WHEN 'super_admin' THEN 1
                                                                            WHEN 'project_manager' THEN 2
                                                                            WHEN 'team_member' THEN 3
                                                                        END, u.username");
                                    while ($u = mysqli_fetch_assoc($users)):
                                        $badge_color = $u['role'] === 'super_admin' ? 'bg-red-800 text-red-200' : ($u['role'] === 'project_manager' ? 'bg-orange-800 text-orange-200' : 'bg-yellow-800 text-yellow-200');
                                    ?>
                                    <tr class="hover:bg-gray-700 transition-colors">
                                        <td class="py-4 px-6 text-sm text-gray-300"><?= $u['id'] ?></td>
                                        <td class="py-4 px-6 text-sm text-gray-100 font-semibold"><?= htmlspecialchars($u['username']) ?></td>
                                        <td class="py-4 px-6 text-sm"><span class="text-xs font-semibold mr-2 px-2.5 py-1 rounded-full <?= $badge_color ?>"><?= ucwords(str_replace('_', ' ', $u['role'])) ?></span></td>
                                        <td class="py-4 px-6 text-sm text-gray-300">
                                            <?php if ($u['role'] === 'team_member'): ?>
                                                <?php if ($u['pm_name']): ?>
                                                    <span class="bg-gray-700 text-gray-300 text-xs font-semibold mr-2 px-2.5 py-1 rounded-full"><?= htmlspecialchars($u['pm_name']) ?></span>
                                                    <button class="text-yellow-500 hover:text-yellow-400" onclick="openModal('editModal<?= $u['id'] ?>')">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                <?php else: ?>
                                                    <span class="text-red-400 text-xs">Belum ada PM</span>
                                                    <button class="ml-2 text-yellow-500 hover:text-yellow-400" onclick="openModal('editModal<?= $u['id'] ?>')">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="text-gray-400">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="py-4 px-6 text-sm">
                                            <?php if ($u['role'] !== 'super_admin'): ?>
                                                <a href="users.php?del=<?= $u['id'] ?>"
                                                   class="bg-red-700 hover:bg-red-800 text-red-200 text-xs font-bold py-2 px-3 rounded-md transition-colors"
                                                   onclick="return confirm('Yakin hapus user <?= htmlspecialchars($u['username']) ?>?')">
                                                    <i class="bi bi-trash-fill"></i> Hapus
                                                </a>
                                            <?php else: ?>
                                                <span class="bg-gray-700 text-gray-400 text-xs font-semibold px-2.5 py-1 rounded-full">Protected</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit PM untuk Team Member -->
                                    <?php if ($u['role'] === 'team_member'): ?>
                                    <div id="editModal<?= $u['id'] ?>" class="modal fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0 text-gray-100">
                                            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeModal('editModal<?= $u['id'] ?>')"></div>
                                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                            <div class="inline-block align-bottom bg-gray-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-700">
                                                <div class="bg-gray-800 px-4 pt-5 pb-4 sm:p-6">
                                                    <div class="flex justify-between items-center pb-3 border-b border-gray-700">
                                                        <h3 class="text-xl leading-6 font-bold text-gray-100" id="modal-title">
                                                            <i class="bi bi-pencil-square mr-2"></i>Edit PM untuk <span class="text-orange-500"><?= htmlspecialchars($u['username']) ?></span>
                                                        </h3>
                                                        <button onclick="closeModal('editModal<?= $u['id'] ?>')" class="text-gray-400 hover:text-gray-600"><i class="bi bi-x-lg"></i></button>
                                                    </div>
                                                    <div class="mt-5">
                                                        <form method="post">
                                                                <input type="hidden" name="action" value="edit">
                                                                <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                                                                <div class="mb-4">
                                                                    <label class="block text-gray-300 text-sm font-bold mb-2">Pilih Project Manager Baru</label>
                                                                    <select class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 transition-all" name="project_manager_id" required>
                                                                        <?php
                                                                        mysqli_data_seek($pm_list, 0); // Reset pointer
                                                                        while ($pm2 = mysqli_fetch_assoc($pm_list)):
                                                                        ?>
                                                                            <option value="<?= $pm2['id'] ?>" <?= $pm2['id'] == $u['project_manager_id'] ? 'selected' : '' ?>>
                                                                                <?= htmlspecialchars($pm2['username']) ?>
                                                                            </option>
                                                                        <?php endwhile; ?>
                                                                    </select>
                                                                </div>
                                                                <div class="pt-4 sm:flex sm:flex-row-reverse">
                                                                    <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-6 py-3 bg-orange-700 text-base font-medium text-white hover:bg-orange-800 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                                                                        Simpan Perubahan
                                                                    </button>
                                                                    <button type="button" onclick="closeModal('editModal<?= $u['id'] ?>')" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-600 shadow-sm px-6 py-3 bg-gray-700 text-base font-medium text-gray-100 hover:bg-gray-600 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm transition-colors">
                                                                        Batal
                                                                    </button>
                                                                </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
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
            document.getElementById('navbarNav').classList.toggle('hidden');
        });

        // Show/hide PM select based on role
        document.getElementById('roleSelect').addEventListener('change', function() {
            const pmDiv = document.getElementById('pmSelectDiv');
            const pmSelect = document.getElementById('pmSelect');
            
            if (this.value === 'team_member') {
                pmDiv.style.display = 'block';
                pmSelect.required = true;
            } else {
                pmDiv.style.display = 'none';
                pmSelect.required = false;
                pmSelect.value = '';
            }
        });

        // Modal logic
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.remove('hidden');
            setTimeout(() => modal.classList.add('opacity-100'), 10); // For transition
            document.body.classList.add('overflow-hidden');
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.remove('opacity-100');
            setTimeout(() => modal.classList.add('hidden'), 250); // Match transition duration
            document.body.classList.remove('overflow-hidden');
        }
    </script>
</body>
</html>