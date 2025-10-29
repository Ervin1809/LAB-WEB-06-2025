<?php
session_start();
require 'koneksi.php';

// ----------- CEK ROLE ADMIN -------------
if (!isset($_SESSION['user']) || strtoupper($_SESSION['user']['role']) !== 'ADMIN') {
    die("Akses ditolak. Hanya Admin yang dapat mengakses halaman ini.");
}

// ----------- HAPUS USER -------------
if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $user_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($user_id === 0) {
        die("ID user tidak ditemukan");
    }

    // Cek user ada atau tidak
    $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) === 0) {
        mysqli_stmt_close($stmt);
        die("User tidak ditemukan di database.");
    }

    mysqli_stmt_close($stmt);

    // Eksekusi hapus user
    $stmt = mysqli_prepare($conn, "DELETE FROM users WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $user_id);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        header("Location: admin_dashboard.php?success=User+berhasil+dihapus");
        exit;
    } else {
        $error = mysqli_error($conn);
        mysqli_stmt_close($stmt);
        die("Gagal menghapus user: $error");
    }
}

// ----------- AMBIL DATA PROJECT MANAGER -------------
$pm_result = mysqli_query($conn, "SELECT id, username FROM users WHERE role = 'MANAGER'");
$message = '';

// ----------- TAMBAH USER -------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username           = trim($_POST['username']);
    $password           = trim($_POST['password']);
    $role               = strtoupper(trim($_POST['role']));
    $project_manager_id = isset($_POST['project_manager_id']) ? trim($_POST['project_manager_id']) : NULL;

    // Validasi input dasar
    if (empty($username) || empty($password) || empty($role)) {
        $message = "<p class='message error'>Semua field wajib diisi!</p>";
    } 
    elseif ($role === 'MEMBER' && (empty($project_manager_id) || $project_manager_id === '')) {
        $message = "<p class='message error'>Member wajib memiliki Manager!</p>";
    } 
    else {
        // Cek apakah username sudah digunakan
        $stmt_check = mysqli_prepare($conn, "SELECT id FROM users WHERE username = ?");
        mysqli_stmt_bind_param($stmt_check, "s", $username);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_store_result($stmt_check);
        $user_exists = mysqli_stmt_num_rows($stmt_check) > 0;
        mysqli_stmt_close($stmt_check);

        if ($user_exists) {
            $message = "<p class='message error'>Username '$username' sudah digunakan. Silakan pilih username lain.</p>";
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            // Jika role MANAGER, maka tidak perlu project_manager_id
            if ($role === 'MANAGER') {
                $project_manager_id = NULL;
            }

            $stmt = mysqli_prepare($conn, "INSERT INTO users (username, password, role, project_manager_id) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "sssi", $username, $password_hash, $role, $project_manager_id);

            if (mysqli_stmt_execute($stmt)) {
                $message = "<p class='message success'>User berhasil ditambahkan!</p>";
            } else {
                $message = "<p class='message error'>Terjadi kesalahan: " . mysqli_error($conn) . "</p>";
            }

            mysqli_stmt_close($stmt);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola User</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #D2B48C 0%, #C19A6B 50%, #A67C52 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            padding: 40px;
            width: 100%;
            max-width: 500px;
        }

        h2 {
            font-size: 28px;
            font-weight: bold;
            color: #8B6F47;
            margin-bottom: 25px;
            text-align: center;
        }

        .back-link {
            display: inline-block;
            color: #8B6F47;
            text-decoration: none;
            margin-bottom: 20px;
            font-weight: 600;
            transition: color 0.3s;
        }

        .back-link:hover {
            color: #6B5037;
            text-decoration: underline;
        }

        .message {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 500;
        }

        .message.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .message.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-group label .required {
            color: #dc3545;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s;
            font-family: inherit;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #A0826D;
        }

        .password-wrapper {
            position: relative;
        }

        .password-wrapper input {
            padding-right: 45px;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            font-size: 18px;
            color: #666;
        }

        .hidden {
            display: none;
        }

        .btn {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-primary {
            background: linear-gradient(to right, #8B6F47, #A0826D);
            color: white;
            box-shadow: 0 4px 15px rgba(139, 111, 71, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(139, 111, 71, 0.4);
        }

        @media (max-width: 480px) {
            .container {
                padding: 25px;
            }

            h2 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Tambah User Baru</h2>
        <a href="admin_dashboard.php" class="back-link">← Kembali ke Dashboard</a>

        <?php if (!empty($message)) echo $message; ?>

        <form method="POST">
            <div class="form-group">
                <label>Username:</label>
                <input type="text" name="username" required>
            </div>

            <div class="form-group">
                <label>Password:</label>
                <div class="password-wrapper">
                    <input id="passwordInput" type="password" name="password" required>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label>Role:</label>
                <select name="role" id="role" onchange="togglePM()" required>
                    <option value="">--Pilih Role--</option>
                    <option value="MANAGER">Manager</option>
                    <option value="MEMBER">Member</option>
                </select>
            </div>

            <div id="pm_select" class="form-group hidden">
                <label>
                    Pilih Manager <span class="required">*</span>
                </label>
                <select name="project_manager_id" id="project_manager_id">
                    <option value="">-- Pilih Manager --</option>
                    <?php 
                    mysqli_data_seek($pm_result, 0);
                    while($pm = mysqli_fetch_assoc($pm_result)) : ?>
                        <option value="<?= htmlspecialchars($pm['id']) ?>"><?= htmlspecialchars($pm['username']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">
                Tambah User
            </button>
        </form>
    </div>

</body>
</html>