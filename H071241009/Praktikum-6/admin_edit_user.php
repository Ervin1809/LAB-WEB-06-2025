<?php
/*
 * File: admin_edit_user.php
 * Deskripsi: Halaman form untuk mengedit user oleh Super Admin.
 */

require_once 'config.php';
require_once 'includes/auth_check.php';

// Proteksi: Hanya Super Admin
if ($_SESSION['role'] !== 'Super Admin') {
    die("Akses ditolak.");
}

// Cek jika ID user ada di URL
if (!isset($_GET['id'])) {
    header('Location: dashboard_admin.php');
    exit;
}

$user_id_to_edit = $_GET['id'];

// Ambil data user yang mau diedit
$stmt_user = $conn->prepare("SELECT username, role, project_manager_id FROM users WHERE id = ?");
$stmt_user->bind_param("i", $user_id_to_edit);
$stmt_user->execute();
$result_user = $stmt_user->get_result();

if ($result_user->num_rows !== 1) {
    $_SESSION['message'] = "User tidak ditemukan.";
    $_SESSION['msg_type'] = "danger";
    header('Location: dashboard_admin.php');
    exit;
}
$user = $result_user->fetch_assoc();
$stmt_user->close();

// Ambil daftar Project Manager (untuk dropdown)
$pm_list = [];
$sql_pm = "SELECT id, username FROM users WHERE role = 'Project Manager'";
$result_pm = $conn->query($sql_pm);
if ($result_pm->num_rows > 0) {
    while($row = $result_pm->fetch_assoc()) {
        $pm_list[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="dashboard_admin.php">Kembali ke Dashboard Admin</a>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <strong>Form Edit User: <?php echo htmlspecialchars($user['username']); ?></strong>
                    </div>
                    <div class="card-body">
                        <form action="admin_update_user.php" method="POST">
                            <input type="hidden" name="user_id" value="<?php echo $user_id_to_edit; ?>">

                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" 
                                       value="<?php echo htmlspecialchars($user['username']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password Baru</label>
                                <input type="password" class="form-control" id="password" name="password">
                                <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                            </div>
                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select class="form-select" id="role" name="role" required onchange="toggleProjectManager()">
                                    <option value="Project Manager" <?php echo ($user['role'] == 'Project Manager') ? 'selected' : ''; ?>>
                                        Project Manager
                                    </option>
                                    <option value="Team Member" <?php echo ($user['role'] == 'Team Member') ? 'selected' : ''; ?>>
                                        Team Member
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3" id="pm-select-div" style="display: none;">
                                <label for="project_manager_id" class="form-label">Pilih Project Manager</label>
                                <select class="form-select" id="project_manager_id" name="project_manager_id">
                                    <option value="">Pilih PM...</option>
                                    <?php foreach ($pm_list as $pm): ?>
                                        <option value="<?php echo $pm['id']; ?>" <?php echo ($user['project_manager_id'] == $pm['id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($pm['username']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Update User</button>
                            <a href="dashboard_admin.php" class="btn btn-secondary w-100 mt-2">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleProjectManager() {
            var roleSelect = document.getElementById('role');
            var pmSelectDiv = document.getElementById('pm-select-div');
            var pmSelect = document.getElementById('project_manager_id');

            if (roleSelect.value === 'Team Member') {
                pmSelectDiv.style.display = 'block'; // Tampilkan
                pmSelect.required = true; // Wajibkan diisi
            } else {
                pmSelectDiv.style.display = 'none'; // Sembunyikan
                pmSelect.required = false; // Tidak wajib
                pmSelect.value = ""; // Kosongkan pilihan
            }
        }
        
        // Panggil fungsi saat halaman pertama kali dimuat
        // untuk mengatur tampilan dropdown PM berdasarkan data yang ada
        document.addEventListener('DOMContentLoaded', toggleProjectManager);
    </script>
</body>
</html>