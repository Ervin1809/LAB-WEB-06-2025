<?php
include('../config/auth.php');
checkRole(['Super Admin']); 
$superadmin_id = $_SESSION['user_id'];
?>

<?php
$user_id = null;
$message = "";

if (isset($_GET['id'])) {
    $user_id = $conn->real_escape_string($_GET['id']);
} else {
    header("Location: manage_users.php");
    exit;
}


$sql_fetch = "SELECT id, username, role, project_manager_id FROM users WHERE id = '$user_id' AND role != 'Super Admin'";
$result_fetch = $conn->query($sql_fetch);

if ($result_fetch->num_rows == 0) {
    header("Location: manage_users.php");
    exit;
}
$user_data = $result_fetch->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_username = $conn->real_escape_string($_POST['username']);
    $new_role = $conn->real_escape_string($_POST['role']);
    $new_password = $_POST['password']; 
    $posted_manager_id = $_POST['project_manager_id'];
    
    $user_data['username'] = $new_username;
    $user_data['role'] = $new_role;
    $user_data['project_manager_id'] = $posted_manager_id;

    $update_fields = [];
    $update_fields[] = "username = '$new_username'";
    $update_fields[] = "role = '$new_role'";

    if (!empty($new_password)) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_fields[] = "password = '$hashed_password'";
    }

    $manager_id_value = "NULL"; 
    
    if ($new_role == 'Team Member') {
        if (empty($posted_manager_id)) {
             $message = "<div class='alert alert-danger'>Team Member wajib memiliki Project Manager yang bertanggung jawab.</div>";
        } else {
            $manager_id_value = "'" . $posted_manager_id . "'";
        }
    }
    
    $update_fields[] = "project_manager_id = " . $manager_id_value;

    $sql_check_username = "SELECT id FROM users WHERE username = '$new_username' AND id != '$user_id'";
    $result_check_username = $conn->query($sql_check_username);
    if ($result_check_username->num_rows > 0) {
        $message = "<div class='alert alert-danger'>Username " . htmlspecialchars($new_username) . " sudah digunakan oleh pengguna lain.</div>";
    }

    if (empty($message)) {
        $sql_update = "UPDATE users SET " . implode(", ", $update_fields) . " WHERE id = '$user_id'";

        if ($conn->query($sql_update) === TRUE) {
            $message = "<div class='alert alert-success'>Data pengguna " . htmlspecialchars($new_username) . " berhasil diupdate.</div>";
            $result_fetch = $conn->query($sql_fetch);
            $user_data = $result_fetch->fetch_assoc();
        } else {
            $message = "<div class='alert alert-danger'>Gagal mengupdate pengguna: " . $conn->error . "</div>";
        }
    }
}

$sql_managers = "SELECT id, username FROM users WHERE role = 'Project Manager' ORDER BY username";
$managers_result = $conn->query($sql_managers);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Pengguna</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
            <h3 class="text-primary">Edit Pengguna: <?php echo htmlspecialchars($user_data['username']); ?></h3>
            <a href="manage_users.php" class="btn btn-secondary">Batal & Kembali</a>
        </div>
        
        <?php echo $message; ?>

        <div class="card p-4 shadow-sm border-0">
            <form action="edit_user.php?id=<?php echo $user_id; ?>" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" 
                            value="<?php echo htmlspecialchars($user_data['username']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="role">Role</label>
                    <select class="form-control" id="role" name="role" required onchange="toggleManagerField(this.value)">
                        <option value="Project Manager" <?php echo ($user_data['role'] == 'Project Manager') ? 'selected' : ''; ?>>Project Manager</option>
                        <option value="Team Member" <?php echo ($user_data['role'] == 'Team Member') ? 'selected' : ''; ?>>Team Member</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                    <small class="form-text text-muted">Hanya isi jika Anda ingin mereset atau mengganti password pengguna.</small>
                </div>
                
                <div class="form-group" id="manager_field">
                    <label for="project_manager_id">Project Manager yang Bertanggung Jawab</label>
                    <select class="form-control" id="project_manager_id" name="project_manager_id">
                        <option value="">-- Pilih Project Manager (Wajib jika Role Team Member) --</option>
                        <?php 
                        if ($managers_result) $managers_result->data_seek(0);
                        while ($manager = $managers_result->fetch_assoc()): ?>
                            <option value="<?php echo $manager['id']; ?>" 
                                    <?php echo ($user_data['project_manager_id'] == $manager['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($manager['username']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                    <small class="form-text text-danger">Hanya berlaku dan wajib diisi jika Role yang dipilih adalah Team Member.</small>
                </div>

                <button type="submit" class="btn btn-primary mt-3">💾 Update Pengguna</button>
            </form>
        </div>

    </div>

    <script>
        function toggleManagerField(role) {
            const managerField = document.getElementById('manager_field');
            const managerSelect = document.getElementById('project_manager_id');
            if (role === 'Team Member') {
                managerField.style.display = 'block';
                managerSelect.setAttribute('required', 'required'); 
            } else {
                managerField.style.display = 'none';
                managerSelect.removeAttribute('required');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const initialRole = document.getElementById('role').value;
            toggleManagerField(initialRole);
        });
    </script>
</body>
</html>