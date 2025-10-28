<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Project Manager') {
    die("Akses ditolak");
}

$manager_id = $_SESSION['user']['id'];
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama      = trim($_POST['nama_proyek']);
    $deskripsi = trim($_POST['deskripsi']);
    $mulai     = $_POST['tanggal_mulai'];
    $selesai   = $_POST['tanggal_selesai'];

    if (empty($nama) || empty($mulai) || empty($selesai)) {
        $message = "<div class='bg-red-100 text-red-700 px-4 py-3 rounded-lg mb-4 text-center font-medium'>
                        Semua field wajib diisi!
                    </div>";
    } elseif (strtotime($selesai) < strtotime($mulai)) {
        $message = "<div class='bg-red-100 text-red-700 px-4 py-3 rounded-lg mb-4 text-center font-medium'>
                        Tanggal selesai tidak boleh lebih kecil dari tanggal mulai!
                    </div>";
    } else {
        $cek_sql  = "SELECT id FROM projects WHERE nama_proyek = ? AND manager_id = ?";
        $cek_stmt = mysqli_prepare($conn, $cek_sql);
        mysqli_stmt_bind_param($cek_stmt, "si", $nama, $manager_id);
        mysqli_stmt_execute($cek_stmt);
        $cek_result = mysqli_stmt_get_result($cek_stmt);

        if (mysqli_num_rows($cek_result) > 0) {
            $message = "<div class='bg-yellow-100 text-yellow-700 px-4 py-3 rounded-lg mb-4 text-center font-medium'>
                            Nama proyek ini sudah ada!
                        </div>";
        } else {
            $sql  = "INSERT INTO projects (nama_proyek, deskripsi, tanggal_mulai, tanggal_selesai, manager_id) 
                     VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssssi", $nama, $deskripsi, $mulai, $selesai, $manager_id);

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
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Proyek</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-500 via-blue-600 to-indigo-700 min-h-screen flex items-center justify-center p-6 font-sans">

    <div class="bg-white/95 backdrop-blur-md p-6 sm:p-8 rounded-2xl shadow-xl w-full max-w-md border border-blue-100">
        <h2 class="text-2xl font-bold text-center text-blue-700 mb-1">Tambah Proyek</h2>
        <p class="text-gray-600 text-center text-sm mb-5">Isi data proyek dengan lengkap</p>

        <a href="manager_dashboard.php"
           class="inline-block text-blue-600 hover:text-blue-800 font-medium mb-3 transition text-sm">&larr; Kembali ke Dashboard</a>

        <?= $message ?>

        <form method="POST" class="space-y-4 mt-3">
            <!-- Nama Proyek -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1 text-sm">Nama Proyek</label>
                <input type="text" name="nama_proyek" required
                       placeholder="Masukkan nama proyek"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800 text-sm">
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1 text-sm">Deskripsi</label>
                <textarea name="deskripsi" rows="3"
                          placeholder="Tuliskan deskripsi singkat..."
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800 text-sm"></textarea>
            </div>

            <!-- Tanggal -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-gray-700 font-semibold mb-1 text-sm">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                           onchange="document.getElementById('tanggal_selesai').min=this.value;">
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-1 text-sm">Tanggal Selesai</label>
                    <input id="tanggal_selesai" type="date" name="tanggal_selesai" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                </div>
            </div>

            <!-- Tombol -->
            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2.5 rounded-lg transition transform hover:scale-105 shadow-md text-sm">
                Simpan Proyek
            </button>
        </form>
    </div>

</body>
</html>
