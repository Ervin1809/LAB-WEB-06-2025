<?php
include('../config/auth.php');
checkRole(['Super Admin']); 
$superadmin_id = $_SESSION['user_id'];
?>

<?php
$message = "";

if (isset($_GET['status'])) {
    if ($_GET['status'] == 'added') {
        $message = "<div class='alert alert-success'>Pengguna berhasil ditambahkan.</div>";
    }
    if ($_GET['status'] == 'updated') {
        $message = "<div class='alert alert-success'>Pengguna berhasil diupdate.</div>";
    }
    if ($_GET['status'] == 'deleted') {
        $message = "<div class='alert alert-success'>Pengguna berhasil dihapus.</div>";
    }
}

if (isset($_GET['delete_id'])) {
    $delete_id = $conn->real_escape_string($_GET['delete_id']);
    $success = false;
    
    $sql_is_manager = "SELECT role, username FROM users WHERE id = '$delete_id' AND role != 'Super Admin' AND id != {$_SESSION['user_id']}";
    $user_info_result = $conn->query($sql_is_manager);
    
    if ($user_info_result->num_rows > 0) {
        $user_info = $user_info_result->fetch_assoc();
        $username_to_delete = htmlspecialchars($user_info['username']);
        
        if ($user_info['role'] === 'Project Manager') {
            
            $sql_check_dependencies = "
                SELECT 
                    (SELECT COUNT(*) FROM projects WHERE manager_id = '$delete_id') as project_count,
                    (SELECT COUNT(*) FROM users WHERE project_manager_id = '$delete_id') as member_count
            ";
            $dependencies = $conn->query($sql_check_dependencies)->fetch_assoc();

            $project_count = $dependencies['project_count'];
            $member_count = $dependencies['member_count'];
            
            
            if ($project_count > 0 || $member_count > 0) {
                $error_msg = "Gagal menghapus Project Manager {$username_to_delete}! Harap alokasikan ulang semua tanggung jawab:<br>";
                if ($project_count > 0) {
                    $error_msg .= " - Masih memiliki {$project_count} proyek aktif.<br>";
                }
                if ($member_count > 0) {
                    $error_msg .= " - Masih membawahi {$member_count} Team Member.<br>";
                }
                $error_msg .= "Gunakan tombol Edit untuk memindahkan proyek dan anggota tim ke Project Manager lain terlebih dahulu.";
                $message = "<div class='alert alert-warning'>{$error_msg}</div>";
                
                goto skip_delete; 
            }
        }
        
        $sql_delete = "DELETE FROM users WHERE id = '$delete_id'";
        
        if ($conn->query($sql_delete) === TRUE) {
            header("Location: manage_users.php?status=deleted");
            exit;
        } else {
            $message = "<div class='alert alert-danger'>Error menghapus pengguna: " . $conn->error . "</div>";
        }

    } else {
        $message = "<div class='alert alert-danger'>Pengguna tidak valid atau tidak diizinkan untuk dihapus (Mungkin Super Admin).</div>";
    }
}

skip_delete: 

$sql = "SELECT 
            u.id, 
            u.username, 
            u.role, 
            pm.username AS manager_username,
            u.project_manager_id
        FROM users u
        LEFT JOIN users pm ON u.project_manager_id = pm.id
        WHERE u.role IN ('Project Manager', 'Team Member')
        ORDER BY u.role DESC, u.username ASC";
        
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Pengguna</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
            <h3 class="text-primary">👥 Kelola Project Manager & Team Member</h3>
            <div>
                <a href="dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
                <a href="add_user.php" class="btn btn-primary">➕ Tambah Pengguna Baru</a>
            </div>
        </div>

        <?php echo $message; ?>

        <div class="table-responsive shadow-sm">
            <table class="table table-hover table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Project Manager</th>
                        <th style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['username']); ?></td>
                                <td>
                                    <?php 
                                    $role_class = ($row['role'] == 'Project Manager') ? 'badge-primary' : 'badge-info';
                                    echo "<span class='badge {$role_class}'>" . htmlspecialchars($row['role']) . "</span>";
                                    ?>
                                </td>
                                <td><?php echo $row['manager_username'] ? htmlspecialchars($row['manager_username']) : '-'; ?></td>
                                <td>
                                    <a href="edit_user.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm mb-1">✏️ Edit</a>
                                    
                                    <a href="manage_users.php?delete_id=<?php echo $row['id']; ?>" 
                                        class="btn btn-danger btn-sm mb-1" 
                                        onclick="return confirm('Yakin ingin menghapus pengguna <?php echo htmlspecialchars($row['username']); ?>? Ini akan permanen.')">
                                        🗑️ Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-4">Belum ada Project Manager atau Team Member yang terdaftar.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</body>
</html>