<?php
include('../config/auth.php');
checkRole(['Super Admin']); 
$superadmin_id = $_SESSION['user_id'];
?>

<?php
$message = "";

$input_username = '';
$input_role = '';
$input_manager_id = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_username = trim($_POST['username'] ?? '');
    $password_raw = $_POST['password'] ?? '';
    $input_role = trim($_POST['role'] ?? '');
    $input_manager_id = $_POST['manager_id'] ?? null;

    if (empty($input_username) || empty($password_raw) || empty($input_role)) {
        $message = "<div class='alert alert-danger'>Semua field wajib diisi.</div>";
    }

    if (empty($message)) {
        $sql_check = "SELECT COUNT(*) FROM users WHERE username = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("s", $input_username);
        $stmt_check->execute();
        $stmt_check->bind_result($count);
        $stmt_check->fetch();
        $stmt_check->close();

        if ($count > 0) {
            $message = "<div class='alert alert-danger'>Gagal: Username " . htmlspecialchars($input_username) . " sudah digunakan. Harap pilih username lain.</div>";
        }
    }
    
    $manager_id = ($input_manager_id !== null && $input_manager_id !== '') ? $conn->real_escape_string($input_manager_id) : null;
    
    if (empty($message) && $input_role == 'Team Member') {
        if ($manager_id === null) {
            $message = "<div class='alert alert-danger'>Wajib menentukan Project Manager untuk Team Member.</div>";
        }
    }

    if (empty($message)) {
        $password_hash = password_hash($password_raw, PASSWORD_DEFAULT);
        
        if ($input_role != 'Team Member') {
            $manager_id = null;
        }

        $sql_insert = "INSERT INTO users (username, password, role, project_manager_id) VALUES (?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        
        if ($manager_id === null) {
            $sql_insert = "INSERT INTO users (username, password, role, project_manager_id) VALUES (?, ?, ?, NULL)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("sss", $input_username, $password_hash, $input_role);
        } else {
            $sql_insert = "INSERT INTO users (username, password, role, project_manager_id) VALUES (?, ?, ?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("sssi", $input_username, $password_hash, $input_role, $manager_id);
        }

        
        if ($stmt_insert->execute()) {
            $message = "<div class='alert alert-success'>Pengguna " . htmlspecialchars($input_username) . " (" . htmlspecialchars($input_role) . ") berhasil ditambahkan.</div>";
            $input_username = '';
            $input_role = '';
            $input_manager_id = '';
        } else {
            $message = "<div class='alert alert-danger'>Error saat eksekusi query: " . $conn->error . "</div>";
        }
        $stmt_insert->close();
    }
}

$sql_managers = "SELECT id, username FROM users WHERE role = 'Project Manager' ORDER BY username";
$managers_result = $conn->query($sql_managers); 
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Pengguna</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
            <h3 class="text-primary">Tambah Project Manager / Team Member</h3>
            <a href="manage_users.php" class="btn btn-secondary">Kembali ke Daftar Pengguna</a>
        </div>
        
        <?php echo $message; ?>

        <div class="card p-4 shadow-sm border-0">
            <form action="add_user.php" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" 
                            value="<?php echo htmlspecialchars($input_username); ?>" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <small class="form-text text-muted">Abaikan jika Anda ingin password tetap kosong saat testing.</small>
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <select class="form-control" id="role" name="role" required onchange="toggleManagerField(this.value)">
                        <option value="">Pilih Role</option>
                        <option value="Project Manager" <?php echo ($input_role == 'Project Manager' ? 'selected' : ''); ?>>Project Manager</option>
                        <option value="Team Member" <?php echo ($input_role == 'Team Member' ? 'selected' : ''); ?>>Team Member</option>
                    </select>
                </div>

                <div class="form-group" id="manager_field" 
                        style="display: <?php echo ($input_role == 'Team Member' ? 'block' : 'none'); ?>;">
                    <label for="manager_id">Project Manager Penanggung Jawab</label>
                    <select class="form-control" id="manager_id" name="manager_id">
                        <option value="">-- Pilih Project Manager --</option>
                        <?php 
                        if ($managers_result) $managers_result->data_seek(0); 
                        while ($manager = $managers_result->fetch_assoc()): ?>
                            <option value="<?php echo $manager['id']; ?>"
                                    <?php echo ($input_manager_id == $manager['id'] ? 'selected' : ''); ?>>
                                <?php echo htmlspecialchars($manager['username']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                    <small class="form-text text-danger">Wajib diisi jika role adalah Team Member.</small>
                </div>

                <button type="submit" class="btn btn-primary mt-3">➕ Simpan Pengguna</button>
            </form>
        </div>

    </div>

    <script>
        function toggleManagerField(role) {
            const managerField = document.getElementById('manager_field');
            const managerSelect = document.getElementById('manager_id');
            if (role === 'Team Member') {
                managerField.style.display = 'block';
                managerSelect.setAttribute('required', 'required'); 
            } else {
                managerField.style.display = 'none';
                managerSelect.removeAttribute('required');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            toggleManagerField(document.getElementById('role').value);
        });
    </script>
</body>
</html>