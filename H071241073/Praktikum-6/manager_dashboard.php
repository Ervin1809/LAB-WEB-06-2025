<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Project Manager') {
    die("Akses ditolak");
}

$manager_id = $_SESSION['user']['id'];

// =========================
// Hitung total proyek
// =========================
$sql = "SELECT COUNT(*) as total_proyek FROM projects WHERE manager_id=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $manager_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$total_proyek = mysqli_fetch_assoc($result)['total_proyek'] ?? 0;

// =========================
// Hitung total tugas
// =========================
$sql = "SELECT COUNT(*) as total_tugas FROM task t
        JOIN projects p ON t.project_id = p.id
        WHERE p.manager_id=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $manager_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$total_tugas = mysqli_fetch_assoc($result)['total_tugas'] ?? 0;

// =========================
// Hitung status tugas
// =========================
$status = ['belum' => 0, 'proses' => 0, 'selesai' => 0];

$sql = "SELECT status, COUNT(*) as jumlah 
        FROM task t 
        JOIN projects p ON t.project_id = p.id
        WHERE p.manager_id=? 
        GROUP BY status";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $manager_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

while ($row = mysqli_fetch_assoc($result)) {
    $status[$row['status']] = $row['jumlah'];
}

// =========================
// Ambil daftar proyek
// =========================
$sql = "SELECT * FROM projects WHERE manager_id=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $manager_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$projects = [];
while ($p = mysqli_fetch_assoc($result)) {
    $projects[] = $p;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Project Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-500 via-blue-600 to-indigo-700 min-h-screen font-sans text-gray-800">

    <!-- NAVBAR -->
    <nav class="bg-white/90 backdrop-blur-md shadow-md p-5">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-extrabold text-blue-700">Dashboard Project Manager</h1>
            <div class="space-x-3">
                <a href="tambah_proyek.php"
                   class="bg-blue-600 text-white px-4 py-2 rounded-xl font-semibold hover:bg-blue-700 transition transform hover:scale-105">
                   Tambah Proyek
                </a>
                <a href="logout.php"
                   class="bg-red-500 text-white px-4 py-2 rounded-xl font-semibold hover:bg-red-600 transition transform hover:scale-105">
                   Logout
                </a>
            </div>
        </div>
    </nav>

    <!-- KONTEN UTAMA -->
    <main class="max-w-7xl mx-auto p-8 sm:p-10">
        <div class="bg-white p-8 sm:p-10 rounded-2xl shadow-2xl space-y-12 border border-blue-100">

            <!-- ==================== RINGKASAN ==================== -->
            <section>
                <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Ringkasan Proyek & Tugas</h2>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div class="bg-blue-50 rounded-2xl shadow p-6 text-center hover:shadow-lg transition">
                        <h3 class="text-gray-600 font-medium">Jumlah Proyek</h3>
                        <p class="text-3xl font-extrabold text-blue-700 mt-2"><?= $total_proyek ?></p>
                    </div>

                    <div class="bg-blue-50 rounded-2xl shadow p-6 text-center hover:shadow-lg transition">
                        <h3 class="text-gray-600 font-medium">Jumlah Tugas</h3>
                        <p class="text-3xl font-extrabold text-blue-700 mt-2"><?= $total_tugas ?></p>
                    </div>

                    <div class="bg-blue-50 rounded-2xl shadow p-6 text-center hover:shadow-lg transition">
                        <h3 class="text-gray-600 font-medium mb-2">Status Tugas</h3>
                        <div class="space-y-1 text-sm">
                            <p class="text-gray-700">Belum: <span class="font-semibold"><?= $status['belum'] ?></span></p>
                            <p class="text-gray-700">Proses: <span class="font-semibold"><?= $status['proses'] ?></span></p>
                            <p class="text-gray-700">Selesai: <span class="font-semibold"><?= $status['selesai'] ?></span></p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ==================== DAFTAR PROYEK ==================== -->
            <section>
                <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Daftar Proyek</h2>

                <?php if (count($projects) === 0): ?>
                    <p class="text-gray-600 text-center italic">Belum ada proyek yang dibuat.</p>
                <?php else: ?>
                    <div class="overflow-x-auto rounded-2xl border border-gray-200 shadow-md">
                        <table class="min-w-full text-center text-gray-700 text-sm">
                            <thead class="bg-blue-50 text-blue-700 uppercase text-xs font-semibold tracking-wide">
                                <tr>
                                    <th class="px-6 py-3">Nama Proyek</th>
                                    <th class="px-6 py-3">Deskripsi</th>
                                    <th class="px-6 py-3">Tanggal Mulai</th>
                                    <th class="px-6 py-3">Tanggal Selesai</th>
                                    <th class="px-6 py-3">Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200">
                                <?php foreach ($projects as $p): ?>
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 font-medium text-gray-800"><?= htmlspecialchars($p['nama_proyek']) ?></td>
                                        <td class="px-6 py-4 text-gray-600"><?= htmlspecialchars($p['deskripsi']) ?></td>
                                        <td class="px-6 py-4"><?= htmlspecialchars($p['tanggal_mulai']) ?></td>
                                        <td class="px-6 py-4"><?= htmlspecialchars($p['tanggal_selesai']) ?></td>
                                        <td class="px-6 py-4 space-x-2">
                                            <a href="edit_proyek.php?id=<?= $p['id'] ?>"
                                               class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-lg text-sm font-medium transition transform hover:scale-105">
                                               Edit
                                            </a>
                                            <a href="hapus_proyek.php?id=<?= $p['id'] ?>"
                                               onclick="return confirm('Yakin ingin menghapus proyek ini?')"
                                               class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm font-medium transition transform hover:scale-105">
                                               Hapus
                                            </a>
                                            <a href="tugas_crud.php?project_id=<?= $p['id'] ?>"
                                               class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-lg text-sm font-medium transition transform hover:scale-105">
                                               Tugas
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </section>
        </div>
    </main>
</body>
</html>
