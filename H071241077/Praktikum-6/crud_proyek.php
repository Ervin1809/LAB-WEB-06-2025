<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user'])) {
    die("Akses ditolak");
}

$user_role = $_SESSION['user']['role'];
$user_id = $_SESSION['user']['id'];
$pemberitahuan = "";

// ==========================
// HAPUS PROYEK
// ==========================
if (isset($_GET['hapus_id'])) {
    $hapus_id = (int)$_GET['hapus_id'];

    if ($user_role === 'MANAGER') {
        $sql = "DELETE FROM projects WHERE id=? AND manager_id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $hapus_id, $user_id);
    } elseif ($user_role === 'ADMIN') {
        $sql = "DELETE FROM projects WHERE id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $hapus_id);
    } else {
        die("Akses ditolak");
    }

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if ($user_role === 'MANAGER') {
        header("Location: manager_dashboard.php");
    } else {
        header("Location: admin_dashboard.php");
    }
    exit();
}

// ==========================
// TAMBAH PROYEK (MANAGER ONLY)
// ==========================
if ($user_role === 'MANAGER' && isset($_POST['tambah'])) {
    $nama = trim($_POST['nama_proyek']);
    $deskripsi = trim($_POST['deskripsi']);
    $mulai = $_POST['tanggal_mulai'];
    $selesai = $_POST['tanggal_selesai'];

    if (empty($nama) || empty($mulai) || empty($selesai)) {
        $pemberitahuan = "Semua field wajib diisi!";
    } else {
        $cek = mysqli_prepare($conn, "SELECT COUNT(*) FROM projects WHERE nama_proyek=? AND manager_id=?");
        mysqli_stmt_bind_param($cek, "si", $nama, $user_id);
        mysqli_stmt_execute($cek);
        mysqli_stmt_bind_result($cek, $jumlah);
        mysqli_stmt_fetch($cek);
        mysqli_stmt_close($cek);

        if ($jumlah > 0) {
            $pemberitahuan = "Nama proyek '$nama' sudah ada!";
        } else {
            $sql = "INSERT INTO projects (nama_proyek, deskripsi, tanggal_mulai, tanggal_selesai, manager_id)
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssssi", $nama, $deskripsi, $mulai, $selesai, $user_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            $pemberitahuan = "Proyek '$nama' berhasil ditambahkan.";
        }
    }
}

// ==========================
// UPDATE PROYEK (MANAGER ONLY)
// ==========================
if ($user_role === 'MANAGER' && isset($_POST['update'])) {
    $id = (int)$_POST['id'];
    $nama = trim($_POST['nama_proyek']);
    $deskripsi = trim($_POST['deskripsi']);
    $mulai = $_POST['tanggal_mulai'];
    $selesai = $_POST['tanggal_selesai'];

    if (empty($nama) || empty($mulai) || empty($selesai)) {
        $pemberitahuan = "Semua field wajib diisi!";
    } else {
        $sql = "UPDATE projects 
                SET nama_proyek=?, deskripsi=?, tanggal_mulai=?, tanggal_selesai=?
                WHERE id=? AND manager_id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssii", $nama, $deskripsi, $mulai, $selesai, $id, $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $pemberitahuan = "Proyek berhasil diperbarui.";
    }
}

// ==========================
// AMBIL DATA PROYEK UNTUK EDIT (MANAGER ONLY)
// ==========================
$edit_data = null;
if ($user_role === 'MANAGER' && isset($_GET['edit_id'])) {
    $edit_id = (int)$_GET['edit_id'];
    $sql = "SELECT * FROM projects WHERE id=? AND manager_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $edit_id, $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $edit_data = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>
        <?php
        if ($user_role === 'MANAGER') {
            echo $edit_data ? 'Edit Proyek' : 'Tambah Proyek';
        } else {
            echo 'Hapus Proyek';
        }
        ?>
    </title>
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
            max-width: 600px;
        }

        h1 {
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

        .alert {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid;
        }

        .alert-warning {
            background: #fff3cd;
            color: #856404;
            border-color: #ffeaa7;
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

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s;
            font-family: inherit;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #A0826D;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
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

        .center-text {
            text-align: center;
        }

        @media (max-width: 480px) {
            .container {
                padding: 25px;
            }

            h1 {
                font-size: 24px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <?php if ($user_role === 'MANAGER'): ?>
    <div class="container">
        <h1><?= $edit_data ? 'Edit Proyek' : 'Tambah Proyek' ?></h1>

        <a href="manager_dashboard.php" class="back-link">← Kembali ke Dashboard</a>

        <?php if (!empty($pemberitahuan)): ?>
            <div class="alert alert-warning">
                <?= htmlspecialchars($pemberitahuan) ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <?php if ($edit_data): ?>
                <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">
            <?php endif; ?>

            <div class="form-group">
                <label>Nama Proyek:</label>
                <input type="text" name="nama_proyek" required
                       value="<?= htmlspecialchars($edit_data['nama_proyek'] ?? '') ?>"
                       placeholder="Masukkan nama proyek">
            </div>

            <div class="form-group">
                <label>Deskripsi:</label>
                <textarea name="deskripsi"
                          placeholder="Deskripsi proyek (opsional)"><?= htmlspecialchars($edit_data['deskripsi'] ?? '') ?></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Tanggal Mulai:</label>
                    <input type="date" id="tanggal_mulai" name="tanggal_mulai" required
                           value="<?= htmlspecialchars($edit_data['tanggal_mulai'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Tanggal Selesai:</label>
                    <input type="date" id="tanggal_selesai" name="tanggal_selesai" required
                           value="<?= htmlspecialchars($edit_data['tanggal_selesai'] ?? '') ?>">
                </div>
            </div>

            <button type="submit" name="<?= $edit_data ? 'update' : 'tambah' ?>" class="btn btn-primary" style="width: 100%;">
                <?= $edit_data ? 'Simpan Perubahan' : 'Tambah Proyek' ?>
            </button>
        </form>
    </div>
    <?php else: ?>
    <div class="container center-text">
        <h1>Admin Hanya Bisa Hapus Proyek</h1>
        <?php if (!empty($pemberitahuan)): ?>
            <div class="alert alert-warning">
                <?= htmlspecialchars($pemberitahuan) ?>
            </div>
        <?php endif; ?>
        <a href="admin_dashboard.php" class="back-link">← Kembali ke Dashboard</a>
    </div>
    <?php endif; ?>

    <script>
        const mulaiInput = document.getElementById('tanggal_mulai');
        const selesaiInput = document.getElementById('tanggal_selesai');

        if (mulaiInput && selesaiInput) {
            mulaiInput.addEventListener('change', () => {
                selesaiInput.min = mulaiInput.value;
                if (selesaiInput.value < mulaiInput.value) selesaiInput.value = mulaiInput.value;
            });

            selesaiInput.addEventListener('change', () => {
                mulaiInput.max = selesaiInput.value;
                if (mulaiInput.value > selesaiInput.value) mulaiInput.value = selesaiInput.value;
            });

            if (mulaiInput.value) selesaiInput.min = mulaiInput.value;
            if (selesaiInput.value) mulaiInput.max = selesaiInput.value;
        }
    </script>
</body>
</html>