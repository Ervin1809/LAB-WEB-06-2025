<?php
session_start();
include('config/koneksi.php'); 

if (isset($_SESSION['user_id'])) {
    if (!isset($_SESSION['role'])) {
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit();
    }
    
    if ($_SESSION['role'] == 'Super Admin') {
        header("Location: super_admin/dashboard.php");
    } elseif ($_SESSION['role'] == 'Project Manager') {
        header("Location: manager/dashboard.php");
    } elseif ($_SESSION['role'] == 'Team Member') {
        header("Location: member/dashboard.php");
    }
    exit();
}

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $username = trim($conn->real_escape_string($_POST['username']));
    $password = $_POST['password']; 

    if (empty($username) || empty($password)) {
        $error_message = "Username dan password wajib diisi.";
    } else {
        $sql = "SELECT id, username, password, role FROM users WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows == 1) {
            $user = $result->fetch_assoc();
            
            if (password_verify($password, $user['password'])) {
               
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                if ($user['role'] == 'Super Admin') {
                    header("Location: super_admin/dashboard.php");
                } elseif ($user['role'] == 'Project Manager') {
                    header("Location: manager/dashboard.php");
                } elseif ($user['role'] == 'Team Member') {
                    header("Location: member/dashboard.php");
                }
                exit();

            } else {
                $error_message = "Kombinasi username atau password salah.";
            }
        } else {
            $error_message = "Kombinasi username atau password salah.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Manajemen Proyek</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css"> 
    <style>
        body { 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            min-height: 100vh; 
            background-color: #f8f9fa; 
        }
        .login-container { 
            width: 100%; 
            max-width: 400px; 
            padding: 30px; 
            background: white; 
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15); 
            border-radius: 10px; 
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2 class="text-center mb-2 text-primary">Sistem Manajemen Proyek</h2>
        <p class="text-center text-muted mb-4">Silakan masuk menggunakan akun Anda</p>
        
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <form action="index.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required autofocus
                        value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block mt-4">🔑 Login</button>
        </form>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>