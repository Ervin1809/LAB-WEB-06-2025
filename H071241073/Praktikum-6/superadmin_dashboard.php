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

    <!-- NAVBAR -->
    <nav class="bg-gradient-to-r from-blue-600 to-indigo-600 p-5 shadow-md">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-3 sm:gap-0">
            <h1 class="text-white text-2xl font-bold tracking-wide text-center sm:text-left">
                Super Admin Dashboard
            </h1>

            <div class="flex flex-col sm:flex-row gap-2">
                <a href="tambah_user.php"
                class="bg-white text-blue-600 px-4 py-2 rounded-lg font-semibold text-center hover:bg-gray-100 transition w-full sm:w-auto">
                    Tambah User
                </a>
                <a href="logout.php"
                class="bg-red-500 text-white px-4 py-2 rounded-lg font-semibold text-center hover:bg-red-600 transition w-full sm:w-auto">
                    Logout
                </a>
            </div>
        </div>
    </nav>

    <!-- KONTEN UTAMA -->
    <div class="max-w-7xl mx-auto p-8 space-y-12">

        <!-- ==================== DAFTAR USER ==================== -->
        <section>
            <h2 class="text-2xl font-bold text-gray-800 mb-5 border-b-2 border-blue-500 pb-2">
                Daftar Semua User
            </h2>

            <div class="overflow-x-auto bg-white rounded-2xl shadow-md border border-gray-200">
                <table class="min-w-full text-center text-sm text-gray-700">
                    <thead class="bg-blue-50 text-blue-700 uppercase text-xs font-semibold tracking-wide">
                        <tr>
                            <th class="px-6 py-3">Username</th>
                            <th class="px-6 py-3">Role</th>
                            <th class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php
                        $user_result = mysqli_query($conn, "SELECT id, username, role FROM users");
                        while ($user = mysqli_fetch_assoc($user_result)) {
                            if ($user['id'] == $_SESSION['user']['id']) continue;

                            $role_color = match($user['role']) {
                                'Project Manager' => 'bg-green-100 text-green-800',
                                'Team Member' => 'bg-yellow-100 text-yellow-800',
                                default => 'bg-gray-100 text-gray-800'
                            };
                        ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-800"><?= htmlspecialchars($user['username']) ?></td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-sm <?= $role_color ?>">
                                    <?= htmlspecialchars($user['role']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="hapus_user.php?id=<?= $user['id'] ?>"
                                   onclick="return confirm('Yakin ingin menghapus user ini?')"
                                   class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-md text-sm font-medium transition">
                                   Hapus
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- ==================== DAFTAR PROYEK ==================== -->
        <section>
            <h2 class="text-2xl font-bold text-gray-800 mb-5 border-b-2 border-blue-500 pb-2">
                Daftar Semua Proyek
            </h2>

            <div class="overflow-x-auto bg-white rounded-2xl shadow-md border border-gray-200">
                <table class="min-w-full text-center text-sm text-gray-700">
                    <thead class="bg-blue-50 text-blue-700 uppercase text-xs font-semibold tracking-wide">
                        <tr>
                            <th class="px-6 py-3">Nama Proyek</th>
                            <th class="px-6 py-3">Tanggal Mulai</th>
                            <th class="px-6 py-3">Tanggal Selesai</th>
                            <th class="px-6 py-3">Manager</th>
                            <th class="px-6 py-3">Member</th>
                            <th class="px-6 py-3">Aksi</th>
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
                            $members = [];
                            $member_result = mysqli_query($conn, "
                                SELECT username 
                                FROM users 
                                WHERE project_manager_id={$row['manager_id']} 
                                AND role='Team Member'
                            ");
                            while ($m = mysqli_fetch_assoc($member_result)) {
                                $members[] = $m['username'];
                            }
                            $members_str = implode(', ', $members);
                        ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-800"><?= htmlspecialchars($row['nama_proyek']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($row['tanggal_mulai']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($row['tanggal_selesai']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($row['manager']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($members_str) ?></td>
                            <td class="px-6 py-4">
                                <a href="hapus_proyek.php?id=<?= $row['id'] ?>"
                                   onclick="return confirm('Yakin ingin menghapus proyek ini?')"
                                   class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-md text-sm font-medium transition">
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
