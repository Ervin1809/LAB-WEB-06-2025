<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Project Manager') {
    die("Akses ditolak");
}

$manager_id = $_SESSION['user']['id'];
$project_id = $_GET['id'] ?? 0;
$message = "";

// Ambil data proyek
$sql_get = "SELECT * FROM projects WHERE id = ? AND manager_id = ?";
$stmt_get = mysqli_prepare($conn, $sql_get);
mysqli_stmt_bind_param($stmt_get, "ii", $project_id, $manager_id);
mysqli_stmt_execute($stmt_get);
$result_get = mysqli_stmt_get_result($stmt_get);
$project = mysqli_fetch_assoc($result_get);

if (!$project) {
    die("Proyek tidak ditemukan atau Anda tidak memiliki akses.");
}

// Proses update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama      = trim($_POST['nama_proyek']);
    $deskripsi = trim($_POST['deskripsi']);
    $mulai     = $_POST['tanggal_mulai'];
    $selesai   = $_POST['tanggal_selesai'];

    if (empty($nama) || empty($mulai) || empty($selesai)) {
        $message = "<p class='text-red-600 font-medium'>Semua field wajib diisi!</p>";
    } 
    elseif (strtotime($selesai) < strtotime($mulai)) {
        $message = "<p class='text-red-600 font-medium'>Tanggal selesai tidak boleh lebih kecil dari tanggal mulai!</p>";
    } 
    else {
        $sql_update  = "UPDATE projects SET nama_proyek = ?, deskripsi = ?, tanggal_mulai = ?, tanggal_selesai = ?
                        WHERE id = ? AND manager_id = ?";
        $stmt_update = mysqli_prepare($conn, $sql_update);
        mysqli_stmt_bind_param($stmt_update, "ssssii", $nama, $deskripsi, $mulai, $selesai, $project_id, $manager_id);

        if (mysqli_stmt_execute($stmt_update)) {
            header("Location: manager_dashboard.php");
            exit();
        } else {
            $message = "<p class='text-red-600 font-medium'>Terjadi kesalahan: ".mysqli_error($conn)."</p>";
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
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4 font-sans">
    <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-lg">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Edit Proyek</h2>
        <a href="manager_dashboard.php" class="inline-block text-blue-600 hover:underline mb-4">&larr; Kembali ke Dashboard</a>
        <?php 
        if (!empty($message)) echo $message; 
        ?>
        <form method="POST" class="space-y-4 mt-4">
            <div>
                <label class="block text-gray-700 font-medium mb-1">Nama Proyek:</label>
                <input type="text" name="nama_proyek" required value="<?= htmlspecialchars($project['nama_proyek']) ?>"
                       class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-1">Deskripsi:</label>
                <textarea name="deskripsi" rows="4"
                          class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"><?= htmlspecialchars($project['deskripsi']) ?></textarea>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Tanggal Mulai:</label>
                    <input type="date" name="tanggal_mulai" required value="<?= htmlspecialchars($project['tanggal_mulai']) ?>"
                           class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           onchange="document.getElementById('tanggal_selesai').min=this.value;">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Tanggal Selesai:</label>
                    <input id="tanggal_selesai" type="date" name="tanggal_selesai" required value="<?= htmlspecialchars($project['tanggal_selesai']) ?>"
                           class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           min="<?= htmlspecialchars($project['tanggal_mulai']) ?>">
                </div>
            </div>
            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-md transition">
                Simpan Perubahan
            </button>
        </form>
    </div>

</body>
</html>