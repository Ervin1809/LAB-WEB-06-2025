<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user'])) {
    die("Akses ditolak");
}

$user = $_SESSION['user'];
$id_tugas = $_GET['id'] ?? 0;

if ($user['role'] === 'Team Member') {

    $sql = "SELECT t.*, p.nama_proyek 
            FROM tasks t 
            JOIN projects p ON t.project_id = p.id
            WHERE t.id=? AND t.assigned_to=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $id_tugas, $user['id']);

} elseif ($user['role'] === 'Project Manager') {

    $sql = "SELECT t.*, p.nama_proyek 
            FROM tasks t
            JOIN projects p ON t.project_id = p.id
            WHERE t.id=? AND p.manager_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $id_tugas, $user['id']);

} else {
    die("Akses ditolak");
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$task = mysqli_fetch_assoc($result);

if (!$task) {
    die("Tugas tidak ditemukan atau tidak boleh diakses.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];
    if ($user['role'] === 'Team Member') {
        $sql = "UPDATE tasks SET status=? WHERE id=? AND assigned_to=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sii", $status, $id_tugas, $user['id']);
    } elseif ($user['role'] === 'Project Manager') {
        $sql = "UPDATE tasks t
                JOIN projects p ON t.project_id = p.id
                SET t.status=?
                WHERE t.id=? AND p.manager_id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sii", $status, $id_tugas, $user['id']);
    }

    mysqli_stmt_execute($stmt);

    if ($user['role'] === 'Team Member') {
        header("Location: member_dashboard.php");
    } else {
        header("Location: tugas_crud.php?project_id=".$task['project_id']);
    }
    exit();
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ubah Status Tugas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen font-sans">

    <header class="w-full bg-blue-600 text-white py-3 px-4 flex justify-between items-center shadow-md">
        <h1 class="text-lg font-bold">Ubah Status Tugas</h1>

        <a href="<?= $user['role']==='Team Member' ? 'member_dashboard.php' : 'tugas_crud.php?project_id='.$task['project_id'] ?>"
           class="bg-red-500 hover:bg-red-600 px-3 py-2 rounded text-sm transition">
           Kembali
        </a>
    </header>

    <main class="w-full max-w-3xl mx-auto p-4 mt-6">

        <div class="bg-white p-4 rounded-xl shadow">

            <h2 class="text-lg font-semibold text-gray-700 mb-4">
                <?= htmlspecialchars($task['nama_tugas']) ?> 
                (<?= htmlspecialchars($task['nama_proyek']) ?>)
            </h2>

            <form method="POST" class="space-y-4">

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Status:</label>
                    <select name="status" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="belum" <?= $task['status'] === 'belum' ? 'selected' : '' ?>>Belum</option>
                        <option value="proses" <?= $task['status'] === 'proses' ? 'selected' : '' ?>>Proses</option>
                        <option value="selesai" <?= $task['status'] === 'selesai' ? 'selected' : '' ?>>Selesai</option>
                    </select>
                </div>

                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-md transition">
                    Simpan
                </button>

            </form>

        </div>

    </main>

</body>
</html>