<?php

session_start(); 

if (isset($_SESSION['user'])) {
    header('Location: dashboard.php'); 
    exit; 
}

$error_message = '';
if (isset($_SESSION['error'])) {
    $error_message = $_SESSION['error'];
    unset($_SESSION['error']); 
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Tugas Praktikum</title>
    <style>
    
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #e9ecef; 
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }
    
    .login-card {
        background-color: #ffffff;
        padding: 40px; 
        border-radius: 10px; 
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); 
        width: 350px; 
    }
    .login-card h2 {
        text-align: center;
        margin-bottom: 30px;
        color: #495057; 
        font-weight: 300; 
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #495057;
    }
    .form-group input {
        width: 100%;
        padding: 12px;
        border: 1px solid #ced4da; 
        border-radius: 5px;
        box-sizing: border-box;
        transition: border-color 0.3s;
    }
    .form-group input:focus {
        border-color: #6c757d; 
        outline: none;
    }
    
    .btn-login {
        width: 100%;
        padding: 12px;
        background-color: #212529; 
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 17px;
        font-weight: 600;
        transition: background-color 0.3s;
    }
    .btn-login:hover {
        background-color: #495057; 
    }
    
    .alert-error {
        background-color: #fcebeb; 
        color: #dc3545;
        padding: 12px;
        border-radius: 5px;
        margin-bottom: 20px;
        border: 1px solid #f5c6cb;
        text-align: center;
    }
</style>
</head>
<body>

<div class="login-card">
    <?php if (!empty($error_message)): ?>
        <div class="alert-error">
            <?php echo htmlspecialchars($error_message); ?>
        </div>
    <?php endif; ?>

    <h2>Silakan Login</h2>

    <form method="POST" action="proses_login.php"> 
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <button type="submit" class="btn-login">Login</button>
        </div>
    </form>
</div>

</body>
</html>