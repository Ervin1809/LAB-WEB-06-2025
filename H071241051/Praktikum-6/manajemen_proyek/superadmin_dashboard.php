<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Super Admin') {
    die("Akses ditolak");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Super Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

    <nav class="bg-gradient-to-r from-blue-600 to-indigo-600 p-4 shadow-md">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="text-white text-2xl font-bold">Super Admin Dashboard</h1>
            <div>
                <span class="text-white mr-4">Selamat datang, <?= htmlspecialchars($_SESSION['user']['username']) ?>!</span>
                <a href="tambah_user.php" class="bg-white text-blue-600 px-4 py-2 rounded-md font-semibold mr-2 hover:bg-gray-100">
                    Tambah User
                </a>
                <a href="logout.php" class="bg-red-500 text-white px-4 py-2 rounded-md font-semibold hover:bg-red-600">
                    Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto p-6 space-y-10">

        <section>
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Daftar Semua User</h2>
            <div class="overflow-x-auto bg-white rounded-xl shadow">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Username</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php
                        $user_result = mysqli_query($conn, "SELECT id, username, role FROM users");
                        while ($user = mysqli_fetch_assoc($user_result)) {
                            if ($user['id'] == $_SESSION['user']['id']) continue; // Jangan tampilkan diri sendiri

                            $role_color = match($user['role']) {
                                'Project Manager' => 'bg-green-200 text-green-800',
                                'Team Member' => 'bg-yellow-200 text-yellow-800',
                                default => 'bg-gray-200 text-gray-800'
                            };
                        ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-800 font-medium"><?= htmlspecialchars($user['username']) ?></td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded-full text-sm <?= $role_color ?>"><?= htmlspecialchars($user['role']) ?></span>
                            </td>
                            <td class="px-4 py-3">
                                <a href="hapus_user.php?id=<?= $user['id'] ?>"
                                   onclick="return confirm('PERHATIAN: Menghapus user ini akan menghapus semua tugas/proyek terkait. Yakin?')"
                                   class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm font-medium">
                                   Hapus
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section>
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Daftar Semua Proyek</h2>
            <div class="overflow-x-auto bg-white rounded-xl shadow">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Proyek</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Manager</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php
                        $project_result = mysqli_query($conn, "
                            SELECT p.*, u.username AS manager 
                            FROM projects p 
                            LEFT JOIN users u ON p.manager_id = u.id
                        ");
                        
                        while ($row = mysqli_fetch_assoc($project_result)) {
                        ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-800 font-medium"><?= htmlspecialchars($row['nama_proyek']) ?></td>
                            <td class="px-4 py-3 text-gray-700"><?= htmlspecialchars($row['manager'] ?? 'N/A') ?></td>
                            <td class="px-4 py-3">
                                <a href="hapus_proyek.php?id=<?= $row['id'] ?>"
                                   onclick="return confirm('PERHATIAN: Menghapus proyek ini akan menghapus semua tugas di dalamnya. Yakin?')"
                                   class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm font-medium">
                                   Hapus
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>

    </div>
</body>
</html>