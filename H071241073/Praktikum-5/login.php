<?php
session_start();
if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit;
}

$error = $_SESSION['error'] ?? "";
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f3f6fa;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
.login-container {
    background: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 10px;
    padding: 35px 30px;
    width: 340px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
}
h2 {
    text-align: center;
    color: #0d8b94;
    margin-bottom: 25px;
    font-weight: 600;
}
label {
    display: block;
    margin-bottom: 6px;
    color: #333;
    font-size: 14px;
}
input[type="text"],
input[type="password"] {
    width: 100%;
    padding: 10px 12px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 14px;
    transition: border 0.2s;
}
input:focus {
    border-color: #0d8b94;
    outline: none;
}
button {
    width: 100%;
    padding: 10px;
    background-color: #0d8b94;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.3s;
}
button:hover {
    background-color: #0a6f76;
}
.error {
    color: #b30000;
    background-color: #ffe5e5;
    border: 1px solid #f5bdbdff;
    padding: 8px;
    border-radius: 5px;
    margin-bottom: 15px;
    text-align: center;
    font-size: 14px;
}
</style>
</head>
<body>
<div class="login-container">
    <h2>Login</h2>

    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="proses_login.php" method="POST">
        <label>Username</label>
        <input type="text" name="username" placeholder="Masukkan username" required>

        <label>Password</label>
        <input type="password" name="password" placeholder="Masukkan password" required>

        <button type="submit">Masuk</button>
    </form>
</div>
</body>
</html>
