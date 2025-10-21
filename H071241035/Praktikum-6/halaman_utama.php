<?php
session_start();

// Security: regenerate session ID
if (!isset($_SESSION['initiated'])) {
    session_regenerate_id(true);
    $_SESSION['initiated'] = true;
}

// Cek login
if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit;
}

require "connect.php";

$role = $_SESSION["role"];
$uid  = (int)$_SESSION["user_id"];
$username = htmlspecialchars($_SESSION["username"]);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Manajemen Proyek</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #9A3412 0%, #451A03 100%); } /* Orange-to-dark gradient */
        .stat-card { transition: all 0.3s ease; }
        .stat-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.3); }
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
                        <a class="block py-2 px-4 text-orange-300 bg-black/30 rounded-lg" href="halaman_utama.php">Dashboard</a>
                    </li>
                    <?php if ($role === "super_admin"): ?>
                        <li class="my-1 md:my-0">
                            <a class="block py-2 px-4 hover:bg-black/20 rounded-lg transition-colors" href="users.php">Kelola Users</a>
                        </li>
                    <?php endif; ?>
                    <?php if ($role === "project_manager" || $role === "super_admin"): ?>
                        <li class="my-1 md:my-0">
                            <a class="block py-2 px-4 hover:bg-black/20 rounded-lg transition-colors" href="projects.php">Projects</a>
                        </li>
                        <li class="my-1 md:my-0">
                            <a class="block py-2 px-4 hover:bg-black/20 rounded-lg transition-colors" href="tasks.php">Tasks</a>
                        </li>
                    <?php elseif ($role === "team_member"): ?>
                        <li class="my-1 md:my-0">
                            <a class="block py-2 px-4 hover:bg-black/20 rounded-lg transition-colors" href="tasks.php?view=my">My Tasks</a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="flex items-center mt-4 md:mt-0 md:ml-6">
                    <span class="text-white mr-3">
                        <i class="bi bi-person-circle text-orange-300"></i> 
                        <strong class="text-orange-300"><?= $username ?></strong>
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
        <h1 class="text-3xl font-bold text-orange-400 mb-6">Dashboard</h1>

        <?php if ($role === "super_admin"): ?>
            <!-- Dashboard Super Admin -->
            <div class="bg-orange-900/50 border-l-4 border-orange-600 text-orange-300 p-4 mb-6 rounded-r-lg" role="alert">
                <i class="bi bi-shield-check"></i> <strong>Super Admin</strong> - Anda memiliki akses penuh ke seluruh sistem
            </div>

            <?php
            $stat = mysqli_query($connect, "SELECT 
                (SELECT COUNT(*) FROM users) AS users,
                (SELECT COUNT(*) FROM users WHERE role='project_manager') AS pm,
                (SELECT COUNT(*) FROM users WHERE role='team_member') AS tm,
                (SELECT COUNT(*) FROM projects) AS projects,
                (SELECT COUNT(*) FROM tasks) AS tasks,
                (SELECT COUNT(*) FROM tasks WHERE status='selesai') AS tasks_done");
            $row = mysqli_fetch_assoc($stat);
            ?>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8 text-gray-100">
                <div class="stat-card bg-gray-800 p-6 rounded-xl shadow-lg flex items-center border border-gray-700">
                    <div class="bg-orange-900 p-4 rounded-full mr-4">
                        <i class="bi bi-people-fill text-3xl text-orange-400"></i>
                    </div>
                    <div>
                        <p class="text-gray-300">Total Users</p>
                        <h3 class="text-3xl font-bold text-gray-100"><?= (int)$row["users"] ?></h3>
                        <small class="text-gray-400">PM: <?= (int)$row["pm"] ?> | TM: <?= (int)$row["tm"] ?></small>
                    </div>
                </div>
                <div class="stat-card bg-gray-800 p-6 rounded-xl shadow-lg flex items-center border border-gray-700">
                    <div class="bg-orange-900 p-4 rounded-full mr-4">
                        <i class="bi bi-folder-fill text-3xl text-orange-400"></i>
                    </div>
                    <div>
                        <p class="text-gray-300">Total Projects</p>
                        <h3 class="text-3xl font-bold text-gray-100"><?= (int)$row["projects"] ?></h3>
                    </div>
                </div>
                <div class="stat-card bg-gray-800 p-6 rounded-xl shadow-lg flex items-center border border-gray-700">
                    <div class="bg-orange-900 p-4 rounded-full mr-4">
                        <i class="bi bi-list-task text-3xl text-orange-400"></i>
                    </div>
                    <div>
                        <p class="text-gray-300">Total Tasks</p>
                        <h3 class="text-3xl font-bold text-gray-100"><?= (int)$row["tasks"] ?></h3>
                        <small class="text-gray-400">Selesai: <?= (int)$row["tasks_done"] ?></small>
                    </div>
                </div>
            </div>

            <!-- Daftar Semua Project --> 
            <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-700">
                <div class="p-6 border-b border-gray-700">
                    <h2 class="text-xl font-semibold text-orange-400"><i class="bi bi-folder2-open mr-2"></i>Semua Proyek</h2>
                </div>
                <div class="p-4">
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-gray-800">
                            <thead class="bg-gray-700">
                                <tr>
                                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">ID</th>
                                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Nama Proyek</th>
                                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Manager</th>
                                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Tanggal Mulai</th>
                                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Tanggal Selesai</th>
                                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700">
                                <?php
                                $q = mysqli_query($connect, "SELECT p.id, p.nama_proyek, p.tanggal_mulai, 
                                                            COALESCE(p.tanggal_selesai,'-') AS tsel, u.username
                                                            FROM projects p 
                                                            JOIN users u ON u.id=p.manager_id 
                                                            ORDER BY p.id DESC");
                                while ($p = mysqli_fetch_assoc($q)):
                                ?>
                                <tr class="hover:bg-gray-700 transition-colors">
                                    <td class="py-4 px-6 text-sm text-gray-300"><?= $p['id'] ?></td>
                                    <td class="py-4 px-6 text-sm text-gray-100 font-semibold"><?= htmlspecialchars($p['nama_proyek']) ?></td>
                                    <td class="py-4 px-6 text-sm text-gray-300"><span class="bg-orange-800 text-orange-200 text-xs font-semibold mr-2 px-2.5 py-1 rounded-full"><?= htmlspecialchars($p['username']) ?></span></td>
                                    <td class="py-4 px-6 text-sm text-gray-300"><?= date("d M Y", strtotime($p['tanggal_mulai'])) ?></td>
                                    <td class="py-4 px-6 text-sm text-gray-300"><?= $p['tsel'] === '-' ? '-' : date("d M Y", strtotime($p['tsel'])) ?></td>
                                    <td class="py-4 px-6 text-sm">
                                        <a href="tasks.php?project=<?= $p['id'] ?>" class="bg-orange-700 hover:bg-orange-800 text-orange-100 text-xs font-bold py-2 px-3 rounded-md transition-colors">
                                            <i class="bi bi-list-check"></i> Tasks
                                        </a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        <?php elseif ($role === "project_manager"): ?>
            <!-- Dashboard Project Manager -->
            <div class="bg-orange-900/50 border-l-4 border-orange-600 text-orange-300 p-4 mb-6 rounded-r-lg" role="alert">
                <i class="bi bi-briefcase"></i> <strong>Project Manager</strong> - Kelola proyek dan tugas Anda
            </div>

            <?php
            $stat = mysqli_query($connect, "SELECT 
                (SELECT COUNT(*) FROM projects WHERE manager_id=$uid) AS my_projects, 
                (SELECT COUNT(*) FROM tasks WHERE project_id IN (SELECT id FROM projects WHERE manager_id=$uid)) AS my_tasks, 
                (SELECT COUNT(*) FROM tasks WHERE status='selesai' AND project_id IN (SELECT id FROM projects WHERE manager_id=$uid)) AS done_tasks"); 
            $row = mysqli_fetch_assoc($stat);
            ?>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8 text-gray-100">
                <div class="stat-card bg-gray-800 p-6 rounded-xl shadow-lg flex items-center border border-gray-700">
                    <div class="bg-orange-900 p-4 rounded-full mr-4">
                        <i class="bi bi-folder-fill text-3xl text-orange-400"></i>
                    </div>
                    <div>
                        <p class="text-gray-300">Proyek Saya</p>
                        <h3 class="text-3xl font-bold text-gray-100"><?= (int)$row["my_projects"] ?></h3>
                    </div>
                </div>
                <div class="stat-card bg-gray-800 p-6 rounded-xl shadow-lg flex items-center border border-gray-700">
                    <div class="bg-orange-900 p-4 rounded-full mr-4">
                        <i class="bi bi-list-task text-3xl text-orange-400"></i>
                    </div>
                    <div>
                        <p class="text-gray-300">Total Tasks</p>
                        <h3 class="text-3xl font-bold text-gray-100"><?= (int)$row["my_tasks"] ?></h3>
                    </div>
                </div>
                <div class="stat-card bg-gray-800 p-6 rounded-xl shadow-lg flex items-center border border-gray-700">
                    <div class="bg-green-800 p-4 rounded-full mr-4">
                        <i class="bi bi-check-circle-fill text-3xl text-green-300"></i>
                    </div>
                    <div>
                        <p class="text-gray-300">Tasks Selesai</p>
                        <h3 class="text-3xl font-bold text-gray-100"><?= (int)$row["done_tasks"] ?></h3>
                    </div>
                </div>
            </div>

            <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-700">
                <div class="p-6 border-b border-gray-700">
                    <h2 class="text-xl font-semibold text-orange-400"><i class="bi bi-folder2-open mr-2"></i>Proyek Saya</h2>
                </div>
                <div class="p-4">
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-gray-800">
                            <thead class="bg-gray-700">
                                <tr>
                                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">ID</th>
                                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Nama Proyek</th>
                                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Tanggal Mulai</th>
                                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Tanggal Selesai</th>
                                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700">
                                <?php
                                $q = mysqli_query($connect, "SELECT id, nama_proyek, tanggal_mulai, 
                                                            COALESCE(tanggal_selesai,'-') AS tsel
                                                            FROM projects WHERE manager_id = $uid 
                                                            ORDER BY id DESC");
                                while ($p = mysqli_fetch_assoc($q)):
                                ?>
                                <tr class="hover:bg-gray-700 transition-colors">
                                    <td class="py-4 px-6 text-sm text-gray-300"><?= $p['id'] ?></td>
                                    <td class="py-4 px-6 text-sm text-gray-100 font-semibold"><?= htmlspecialchars($p['nama_proyek']) ?></td>
                                    <td class="py-4 px-6 text-sm text-gray-300"><?= date("d M Y", strtotime($p['tanggal_mulai'])) ?></td>
                                    <td class="py-4 px-6 text-sm text-gray-300"><?= $p['tsel'] === '-' ? '-' : date("d M Y", strtotime($p['tsel'])) ?></td>
                                    <td class="py-4 px-6 text-sm">
                                        <a href="tasks.php?project=<?= $p['id'] ?>" class="bg-orange-700 hover:bg-orange-800 text-orange-100 text-xs font-bold py-2 px-3 rounded-md transition-colors">
                                            <i class="bi bi-list-check"></i> Tasks
                                        </a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        <?php else: // team_member ?>
            <!-- Dashboard Team Member -->
            <div class="bg-orange-900/50 border-l-4 border-orange-600 text-orange-300 p-4 mb-6 rounded-r-lg" role="alert">
                <i class="bi bi-person-check"></i> <strong>Team Member</strong> - Lihat dan update status tugas Anda
            </div>

            <?php
            $stat = mysqli_query($connect, "SELECT 
                (SELECT COUNT(*) FROM tasks WHERE assigned_to=$uid) AS my_tasks, 
                (SELECT COUNT(*) FROM tasks WHERE assigned_to=$uid AND status='belum') AS pending, 
                (SELECT COUNT(*) FROM tasks WHERE assigned_to=$uid AND status='proses') AS progress, 
                (SELECT COUNT(*) FROM tasks WHERE assigned_to=$uid AND status='selesai') AS done"); 
            $row = mysqli_fetch_assoc($stat);
            ?>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 text-gray-100">
                <div class="stat-card bg-gray-800 p-6 rounded-xl shadow-lg border border-gray-700">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-300">Total Tugas</p>
                            <h3 class="text-3xl font-bold text-gray-100"><?= (int)$row["my_tasks"] ?></h3>
                        </div>
                        <div class="bg-orange-900 p-3 rounded-full">
                            <i class="bi bi-list-task text-xl text-orange-400"></i>
                        </div>
                    </div>
                </div>
                <div class="stat-card bg-gray-800 p-6 rounded-xl shadow-lg border border-gray-700">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-300">Belum Dikerjakan</p>
                            <h3 class="text-3xl font-bold text-gray-100"><?= (int)$row["pending"] ?></h3>
                        </div>
                        <div class="bg-gray-700 p-3 rounded-full">
                            <i class="bi bi-hourglass-split text-xl text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="stat-card bg-gray-800 p-6 rounded-xl shadow-lg border border-gray-700">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-300">Sedang Proses</p>
                            <h3 class="text-3xl font-bold text-gray-100"><?= (int)$row["progress"] ?></h3>
                        </div>
                        <div class="bg-yellow-700 p-3 rounded-full">
                            <i class="bi bi-clock-history text-xl text-yellow-200"></i>
                        </div>
                    </div>
                </div>
                <div class="stat-card bg-gray-800 p-6 rounded-xl shadow-lg border border-gray-700">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-300">Selesai</p>
                            <h3 class="text-3xl font-bold text-gray-100"><?= (int)$row["done"] ?></h3>
                        </div>
                        <div class="bg-green-800 p-3 rounded-full">
                            <i class="bi bi-check-circle-fill text-xl text-green-300"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-700">
                <div class="p-6 border-b border-gray-700">
                    <h2 class="text-xl font-semibold text-orange-400"><i class="bi bi-list-check mr-2"></i>Tugas Saya</h2>
                </div>
                <div class="p-4">
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-gray-800">
                            <thead class="bg-gray-700">
                                <tr>
                                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">ID</th>
                                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Nama Tugas</th>
                                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Proyek</th>
                                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700">
                                <?php
                                $stm = mysqli_prepare($connect, "SELECT t.id, t.nama_tugas, t.status, p.nama_proyek
                                                                FROM tasks t 
                                                                JOIN projects p ON p.id=t.project_id
                                                                WHERE t.assigned_to=? 
                                                                ORDER BY t.id DESC");
                                mysqli_stmt_bind_param($stm, "i", $uid); 
                                mysqli_stmt_execute($stm); 
                                $res = mysqli_stmt_get_result($stm);
                                while ($t = mysqli_fetch_assoc($res)):
                                    $badge_color = $t['status'] === 'selesai' ? 'bg-green-800 text-green-300' : ($t['status'] === 'proses' ? 'bg-yellow-800 text-yellow-300' : 'bg-gray-700 text-gray-300');
                                ?>
                                <tr class="hover:bg-gray-700 transition-colors">
                                    <td class="py-4 px-6 text-sm text-gray-300"><?= $t['id'] ?></td>
                                    <td class="py-4 px-6 text-sm text-gray-100 font-semibold"><?= htmlspecialchars($t['nama_tugas']) ?></td>
                                    <td class="py-4 px-6 text-sm text-gray-300"><?= htmlspecialchars($t['nama_proyek']) ?></td>
                                    <td class="py-4 px-6 text-sm"><span class="text-xs font-semibold mr-2 px-2.5 py-1 rounded-full <?= $badge_color ?>"><?= ucwords($t['status']) ?></span></td>
                                    <td class="py-4 px-6 text-sm">
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
        <?php endif; ?>
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