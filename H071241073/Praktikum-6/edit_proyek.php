<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Project Manager') {
    die("Akses ditolak");
}

$id = $_GET['id'] ?? 0;
$manager_id = $_SESSION['user']['id'];

$query = "SELECT * FROM projects WHERE id = ? AND manager_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ii", $id, $manager_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$proyek = mysqli_fetch_assoc($result);

if (!$proyek) {
    die("Proyek tidak ditemukan atau akses ditolak");
}

$tanggal_selesai_lama = $proyek['tanggal_selesai'];
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_proyek = trim($_POST['nama_proyek']);
    $deskripsi = trim($_POST['deskripsi']);
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];

    if (empty($nama_proyek) || empty($tanggal_mulai) || empty($tanggal_selesai)) {
        $message = "<div class='bg-red-100 text-red-700 px-4 py-3 rounded-lg mb-4 text-center font-medium'>
                        Semua field wajib diisi!
                    </div>";
    } elseif (strtotime($tanggal_selesai) < strtotime($tanggal_selesai_lama)) {
        $message = "<div class='bg-yellow-100 text-yellow-700 px-4 py-3 rounded-lg mb-4 text-center font-medium'>
                        Tanggal selesai tidak boleh lebih kecil dari tanggal sebelumnya!
                    </div>";
    } else {
        $update = "UPDATE projects 
                   SET nama_proyek = ?, deskripsi = ?, tanggal_mulai = ?, tanggal_selesai = ?
                   WHERE id = ? AND manager_id = ?";
        $stmt = mysqli_prepare($conn, $update);
        mysqli_stmt_bind_param($stmt, "ssssii",
            $nama_proyek, $deskripsi, $tanggal_mulai, $tanggal_selesai, $id, $manager_id
        );

        if (mysqli_stmt_execute($stmt)) {
            header("Location: manager_dashboard.php");
            exit();
        } else {
            $message = "<div class='bg-red-100 text-red-700 px-4 py-3 rounded-lg mb-4 text-center font-medium'>
                            Terjadi kesalahan: " . mysqli_error($conn) . "
                        </div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Proyek</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-blue-500 via-blue-600 to-indigo-700 min-h-screen flex items-center justify-center p-6 font-sans">

    <div class="bg-white/95 backdrop-blur-md p-6 sm:p-8 rounded-2xl shadow-xl w-full max-w-md border border-blue-100">
        <h2 class="text-2xl font-bold text-center text-blue-700 mb-1">Edit Proyek</h2>
        <p class="text-gray-600 text-center text-sm mb-5">Perbarui data proyek dengan benar</p>

        <a href="manager_dashboard.php"
           class="inline-block text-blue-600 hover:text-blue-800 font-medium mb-3 transition text-sm">&larr; Kembali ke Dashboard</a>

        <?= $message ?>

        <form method="POST" class="space-y-4 mt-3">
            <!-- Nama Proyek -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1 text-sm">Nama Proyek</label>
                <input type="text" name="nama_proyek"
                       value="<?= htmlspecialchars($proyek['nama_proyek']) ?>" required
                       placeholder="Masukkan nama proyek"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none 
                              focus:ring-2 focus:ring-blue-500 text-gray-800 text-sm">
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1 text-sm">Deskripsi</label>
                <textarea name="deskripsi" rows="3" 
                          placeholder="Tuliskan deskripsi singkat..."
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none 
                                 focus:ring-2 focus:ring-blue-500 text-gray-800 text-sm"><?= htmlspecialchars($proyek['deskripsi']) ?></textarea>
            </div>

            <!-- Tanggal -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-gray-700 font-semibold mb-1 text-sm">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai"
                           value="<?= $proyek['tanggal_mulai'] ?>" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none 
                                  focus:ring-2 focus:ring-blue-500 text-sm">
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-1 text-sm">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai"
                           value="<?= $proyek['tanggal_selesai'] ?>" required
                           min="<?= $tanggal_selesai_lama ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none 
                                  focus:ring-2 focus:ring-blue-500 text-sm">
                </div>
            </div>

            <!-- Tombol -->
            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2.5 rounded-lg 
                           transition transform hover:scale-105 shadow-md text-sm">
                Simpan Perubahan
            </button>
        </form>
    </div>

</body>
</html>
