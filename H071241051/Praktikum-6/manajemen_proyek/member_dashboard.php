<?php
require 'koneksi.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Team Member') {
    die("Akses ditolak");
}

$member_id = (int)$_SESSION['user']['id'];
$username = htmlspecialchars($_SESSION['user']['username']);

// Ambil daftar tugas untuk member ini
$tasks = [];
$sql = "SELECT t.id, t.nama_tugas, t.deskripsi, t.status, p.nama_proyek 
        FROM tasks t
        JOIN projects p ON t.project_id = p.id
        WHERE t.assigned_to = ?
        ORDER BY FIELD(t.status, 'proses', 'belum', 'selesai'), p.nama_proyek";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $member_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
while($row = mysqli_fetch_assoc($result)) {
    $tasks[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Team Member</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans min-h-screen">

    <nav class="bg-gradient-to-r from-purple-600 to-indigo-600 p-4 shadow-md">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="text-white text-2xl font-bold">Team Member Dashboard</h1>
            <div>
                <span class="text-white mr-4">Selamat datang, <?= $username ?>!</span>
                <a href="logout.php" class="bg-red-500 text-white px-4 py-2 rounded-md font-semibold hover:bg-red-600">
                    Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Daftar Tugas Saya</h2>
        
        <?php if (empty($tasks)): ?>
            <p class="bg-white p-6 rounded-xl shadow text-gray-600 text-lg">Anda belum memiliki tugas.</p>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($tasks as $tugas): ?>
                    <?php
                    $status_color = match($tugas['status']) {
                        'belum' => 'border-gray-300',
                        'proses' => 'border-blue-500',
                        'selesai' => 'border-green-500',
                    };
                    $status_text_color = match($tugas['status']) {
                        'belum' => 'text-gray-600',
                        'proses' => 'text-blue-600',
                        'selesai' => 'text-green-600',
                    };
                    ?>
                    <div class="bg-white rounded-xl shadow p-5 flex flex-col justify-between border-t-4 <?= $status_color ?>">
                        <div>
                            <span class="block text-sm font-medium text-gray-500"><?= htmlspecialchars($tugas['nama_proyek']) ?></span>
                            <h3 class="text-lg font-semibold text-gray-800 mt-1"><?= htmlspecialchars($tugas['nama_tugas']) ?></h3>
                            <p class="text-gray-600 text-sm mt-2 mb-4"><?= htmlspecialchars($tugas['deskripsi'] ?? 'Tidak ada deskripsi.') ?></p>
                        </div>
                        <div class="flex justify-between items-center">
                             <span class="font-bold text-sm capitalize <?= $status_text_color ?>">
                                <?= htmlspecialchars($tugas['status']) ?>
                             </span>
                            <a href="ubah_status.php?id=<?= $tugas['id'] ?>" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md text-sm font-medium transition">
                                Ubah Status
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>