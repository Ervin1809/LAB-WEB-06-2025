<?php
session_start();

$message = $_SESSION['error'] ?? '';
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Sistem Manajemen Proyek</title>
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

        .login-container {
            background: linear-gradient(to bottom, #8B6F47 0%, #A0826D 100%);
            border-radius: 25px 25px 0 0;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 450px;
            overflow: hidden;
        }

        .login-header {
            padding: 40px 30px 30px;
            text-align: center;
            color: white;
        }

        .login-header h2 {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .login-header p {
            font-size: 14px;
            color: rgba(255,255,255,0.9);
        }

        .login-body {
            background: white;
            padding: 40px 30px;
            border-radius: 0 0 25px 25px;
        }

        .error-message {
            background-color: #fee;
            color: #c33;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 14px;
            border: 1px solid #fcc;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 15px;
        }

        .form-group input {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 15px;
            transition: border-color 0.3s;
            color: #333;
        }

        .form-group input:focus {
            outline: none;
            border-color: #A0826D;
        }

        .form-group input::placeholder {
            color: #999;
        }

        .btn-login {
            width: 100%;
            padding: 15px;
            background: linear-gradient(to right, #8B6F47, #A0826D);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(139, 111, 71, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(139, 111, 71, 0.4);
            background: linear-gradient(to right, #6B5037, #80624D);
        }

        .demo-info {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
            text-align: center;
        }

        .demo-info p {
            color: #666;
            font-size: 13px;
        }

        @media (max-width: 480px) {
            .login-header h2 {
                font-size: 26px;
            }
            
            .login-body {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h2>Manajemen Proyek</h2>
            <p>Silakan login untuk melanjutkan</p>
        </div>

        <div class="login-body">
            <?php if (!empty($message)) : ?>
                <div class="error-message">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="proses_login.php">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Masukkan username" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Masukkan password" required>
                </div>

                <button type="submit" class="btn-login">Login</button>
            </form>

            <div class="demo-info">
                <p>Contoh: superadmin / admin123</p>
            </div>
        </div>
    </div>
</body>
</html>