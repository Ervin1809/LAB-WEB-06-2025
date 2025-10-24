<?php
require 'koneksi.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Project Manager') {
    die("Akses ditolak");
}

$manager_id = (int)$_SESSION['user']['id'];
$username = htmlspecialchars($_SESSION['user']['username']);

// Ambil daftar proyek
$projects = [];
$sql_proj = "SELECT * FROM projects WHERE manager_id = ? ORDER BY tanggal_mulai DESC";
$stmt_proj = mysqli_prepare($conn, $sql_proj);
mysqli_stmt_bind_param($stmt_proj, "i", $manager_id);
mysqli_stmt_execute($stmt_proj);
$result_proj = mysqli_stmt_get_result($stmt_proj);
while($row = mysqli_fetch_assoc($result_proj)) {
    $projects[] = $row;
}

// Ambil daftar team member
$members = [];
$sql_mem = "SELECT id, username FROM users WHERE project_manager_id = ? AND role = 'Team Member'";
$stmt_mem = mysqli_prepare($conn, $sql_mem);
mysqli_stmt_bind_param($stmt_mem, "i", $manager_id);
mysqli_stmt_execute($stmt_mem);
$result_mem = mysqli_stmt_get_result($stmt_mem);
while($row = mysqli_fetch_assoc($result_mem)) {
    $members[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Project Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

    <nav class="bg-gradient-to-r from-green-600 to-teal-600 p-4 shadow-md">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="text-white text-2xl font-bold">Project Manager Dashboard</h1>
            <div>
                <span class="text-white mr-4">Selamat datang, <?= $username ?>!</span>
                <a href="tambah_proyek.php" class="bg-white text-green-600 px-4 py-2 rounded-md font-semibold mr-2 hover:bg-gray-100">
                    Tambah Proyek
                </a>
                <a href="tugas_crud.php" class="bg-white text-green-600 px-4 py-2 rounded-md font-semibold mr-2 hover:bg-gray-100">
                    Kelola Tugas
                </a>
                <a href="logout.php" class="bg-red-500 text-white px-4 py-2 rounded-md font-semibold hover:bg-red-600">
                    Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <div class="md:col-span-2 space-y-6">
            <h2 class="text-2xl font-bold text-gray-800">Proyek Saya</h2>
            <?php if (empty($projects)): ?>
                <p class="bg-white p-4 rounded-xl shadow text-gray-600">Anda belum memiliki proyek. Silakan buat proyek baru.</p>
            <?php else: ?>
                <div class="overflow-x-auto bg-white rounded-xl shadow">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Proyek</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tgl Mulai</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tgl Selesai</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php foreach ($projects as $proj): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-gray-800 font-medium"><?= htmlspecialchars($proj['nama_proyek']) ?></td>
                                <td class="px-4 py-3 text-gray-700"><?= htmlspecialchars($proj['tanggal_mulai']) ?></td>
                                <td class="px-4 py-3 text-gray-700"><?= htmlspecialchars($proj['tanggal_selesai']) ?></td>
                                <td class="px-4 py-3 space-x-2">
                                    <a href="edit_proyek.php?id=<?= $proj['id'] ?>" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-md text-sm font-medium">Edit</a>
                                    <a href="hapus_proyek.php?id=<?= $proj['id'] ?>" onclick="return confirm('Yakin ingin menghapus proyek ini? Semua tugas di dalamnya akan terhapus.')" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm font-medium">Hapus</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <div class="space-y-6">
            <h2 class="text-2xl font-bold text-gray-800">Team Member Saya</h2>
            <div class="bg-white rounded-xl shadow p-4">
                <?php if (empty($members)): ?>
                    <p class="text-gray-600">Anda belum memiliki team member.</p>
                <?php else: ?>
                    <ul class="divide-y divide-gray-200">
                        <?php foreach ($members as $mem): ?>
                            <li class="py-3 text-gray-700 font-medium"><?= htmlspecialchars($mem['username']) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>

</body>
</html>