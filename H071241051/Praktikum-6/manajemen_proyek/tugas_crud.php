<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Project Manager') {
    die("Akses ditolak");
}

$manager_id  = $_SESSION['user']['id'];
$project_id  = $_GET['project_id'] ?? 0;
$pemberitahuan = "";

// =======================
// Tambah Tugas
// =======================
if (isset($_POST['tambah'])) {

    $nama_tugas   = trim($_POST['nama_tugas']);
    $deskripsi    = trim($_POST['deskripsi']); // Tambahkan deskripsi
    $assigned_to  = $_POST['assigned_to'];
    $project_id   = $_POST['project_id'];

    if (!empty($nama_tugas) && !empty($assigned_to) && !empty($project_id)) {
        
        // Cek dulu apakah member ini ada di bawah naungan PM
        $sql_cek_member = "SELECT id FROM users WHERE id = ? AND project_manager_id = ?";
        $stmt_cek = mysqli_prepare($conn, $sql_cek_member);
        mysqli_stmt_bind_param($stmt_cek, "ii", $assigned_to, $manager_id);
        mysqli_stmt_execute($stmt_cek);
        $result_cek = mysqli_stmt_get_result($stmt_cek);

        if(mysqli_num_rows($result_cek) == 0) {
            $pemberitahuan = "Error: Team member tidak valid.";
        } else {
            $sql = "INSERT INTO tasks (nama_tugas, deskripsi, project_id, assigned_to) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssii", $nama_tugas, $deskripsi, $project_id, $assigned_to);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            $pemberitahuan = "Tugas '$nama_tugas' berhasil ditambahkan.";
        }

    } else {
         $pemberitahuan = "Nama tugas dan team member wajib diisi.";
    }

}

// =======================
// Hapus Tugas
// =======================
if (isset($_GET['hapus_id'])) {

    $hapus_id = $_GET['hapus_id'];
    $sql = "DELETE t FROM tasks t
            JOIN projects p ON t.project_id = p.id
            WHERE t.id=? AND p.manager_id=?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $hapus_id, $manager_id);
    mysqli_stmt_execute($stmt);

    header("Location: tugas_crud.php?project_id=" . $project_id);
    exit();
}

// =====================================
// Ambil daftar proyek milik manager ini
// =====================================
$project_list = [];
$sql = "SELECT id, nama_proyek FROM projects WHERE manager_id=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $manager_id);
$stmt->execute();
$result = mysqli_stmt_get_result($stmt);

while ($row = mysqli_fetch_assoc($result)) {
    $project_list[] = $row;
}

if ($project_id == 0 && count($project_list) > 0) {
    $project_id = $project_list[0]['id'];
}

// =======================
// Daftar team member
// =======================
$team_members = [];
$sql = "SELECT id, username FROM users WHERE role='Team Member' AND project_manager_id=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $manager_id);
$stmt->execute();
$result = mysqli_stmt_get_result($stmt);

while ($row = mysqli_fetch_assoc($result)) {
    $team_members[] = $row;
}

// =======================
// Daftar tugas di proyek
// =======================
$tasks = [];
if($project_id > 0) {
    $sql = "SELECT t.id, t.nama_tugas, t.status, u.username AS member
            FROM tasks t
            JOIN users u ON t.assigned_to = u.id
            WHERE t.project_id=? 
            ORDER BY t.id ASC";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $project_id);
    $stmt->execute();
    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        $tasks[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>CRUD Tugas Project Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans min-h-screen">

    <header class="w-full bg-blue-600 text-white p-4 sm:p-6 flex justify-between items-center shadow-md">
        <h1 class="text-2xl sm:text-3xl font-bold">Tugas Proyek</h1>
        <a href="manager_dashboard.php" 
           class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded text-base sm:text-lg transition">
           Kembali ke Dashboard
        </a>
    </header>

    <main class="w-full max-w-6xl mx-auto p-4 sm:p-6 space-y-6">

        <?php if (!empty($pemberitahuan)): ?>
            <div class="p-3 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded">
                <?= htmlspecialchars($pemberitahuan) ?>
            </div>
        <?php endif; ?>

        <?php if (empty($project_list)): ?>
            <div class="bg-white p-6 rounded-xl shadow">
                <p class="text-gray-700 text-lg">Anda harus <a href="tambah_proyek.php" class="text-blue-600 font-semibold hover:underline">membuat proyek</a> terlebih dahulu sebelum bisa menambahkan tugas.</p>
            </div>
        <?php elseif(empty($team_members)): ?>
             <div class="bg-white p-6 rounded-xl shadow">
                <p class="text-gray-700 text-lg">Anda tidak memiliki Team Member. Super Admin harus <a href="tambah_user.php" class="text-blue-600 font-semibold hover:underline">(pura-pura)</a> menambahkan Team Member untuk Anda terlebih dahulu.</p>
            </div>
        <?php else: ?>

            <div class="mb-4">
                <form method="GET" class="flex flex-col sm:flex-row items-start sm:items-center gap-2">
                    <label class="font-medium text-gray-700">Pilih Proyek:</label>
                    <select name="project_id" onchange="this.form.submit()" 
                            class="px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <?php foreach ($project_list as $proj): ?>
                            <option value="<?= $proj['id'] ?>" <?= $proj['id']==$project_id?'selected':'' ?>>
                                <?= htmlspecialchars($proj['nama_proyek']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <section class="lg:col-span-2">
                    <h2 class="text-xl font-semibold text-gray-700 mb-3">Daftar Tugas</h2>
                    <?php if (empty($tasks)): ?>
                        <p class="bg-white p-4 rounded-xl shadow text-gray-600">Belum ada tugas di proyek ini.</p>
                    <?php else: ?>
                        <div class="overflow-x-auto bg-white rounded-xl shadow">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tugas</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned To</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <?php foreach ($tasks as $tugas): ?>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-3 py-2 text-gray-800"><?= htmlspecialchars($tugas['nama_tugas']) ?></td>
                                            <td class="px-3 py-2 text-gray-800"><?= htmlspecialchars($tugas['member']) ?></td>
                                            <td class="px-3 py-2 text-gray-800 capitalize"><?= $tugas['status'] ?></td>
                                            <td class="px-3 py-2 flex flex-wrap gap-2">
                                                <a href="ubah_status.php?id=<?= $tugas['id'] ?>" 
                                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded-md text-sm transition">
                                                   Ubah Status
                                                </a>
                                                <a href="tugas_crud.php?project_id=<?= $project_id ?>&hapus_id=<?= $tugas['id'] ?>" 
                                                   onclick="return confirm('Yakin ingin menghapus?')" 
                                                   class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded-md text-sm transition">
                                                   Hapus
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-gray-700 mb-3">Tambah Tugas</h2>
                    <form method="POST" class="space-y-4 bg-white p-4 sm:p-6 rounded-xl shadow">
                        <input type="hidden" name="project_id" value="<?= $project_id ?>">

                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Nama Tugas:</label>
                            <input type="text" name="nama_tugas" required 
                                   class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm sm:text-base">
                        </div>
                        
                         <div>
                            <label class="block text-gray-700 font-medium mb-1">Deskripsi:</label>
                            <textarea name="deskripsi" rows="3"
                                      class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Assign ke Team Member:</label>
                            <select name="assigned_to" required 
                                    class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm sm:text-base">
                                <option value="">--Pilih Member--</option>
                                <?php foreach ($team_members as $tm): ?>
                                    <option value="<?= $tm['id'] ?>"><?= htmlspecialchars($tm['username']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <button type="submit" name="tambah" 
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-md transition text-sm sm:text-base">
                            Tambah Tugas
                        </button>
                    </form>
                </section>
            </div>
        <?php endif; ?>
    </main>

</body>
</html>