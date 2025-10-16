<?php
session_start();

// Jika sudah ada session, redirect ke dashboard
if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <form action="proses_login.php" method="post" class="login-form">
            <h2>Silakan Login</h2>
            
            <?php
            // Tampilkan pesan error jika ada
            if (isset($_SESSION['error'])) {
                echo '<div class="error-message">' . $_SESSION['error'] . '</div>';
                unset($_SESSION['error']); // Hapus pesan error setelah ditampilkan
            }
            ?>

            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required autocomplete = "off">
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</body>
</html>