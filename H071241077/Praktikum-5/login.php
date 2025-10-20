<?php
session_start();

if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
if (!empty($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
}

$blocked_until = $_SESSION['blocked_until'] ?? null;
$blocked_message = '';
if ($blocked_until && $blocked_until > time()) {
    $remaining = $blocked_until - time();
    $blocked_message = "Terlalu banyak percobaan. Coba lagi setelah {$remaining} detik.";
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>Login</title>
  <style>
  body {
    font-family: 'Segoe UI', Arial, sans-serif;
    background: linear-gradient(135deg, #e3f2fd, #bbdefb);
    color: #0d47a1;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    margin: 0;
  }

  .card {
    background: #ffffff;
    padding: 28px 32px;
    border-radius: 10px;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
    width: 340px;
  }

  h2 {
    margin: 0 0 20px 0;
    text-align: center;
    color: #1565c0;
  }

  .error {
    background: #ffe6e6;
    color: #b71c1c;
    padding: 8px 10px;
    border-radius: 6px;
    margin-bottom: 12px;
    text-align: center;
    font-size: 14px;
  }

  form {
    display: flex;
    flex-direction: column;
    gap: 16px;
  }

  label {
    display: block;
    font-size: 14px;
    color: #0d47a1;
    margin-bottom: 6px;
  }

  input[type="text"],
  input[type="password"] {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #90caf9;
    border-radius: 6px;
    font-size: 14px;
    transition: border-color 0.2s;
    box-sizing: border-box;
  }

  input:focus {
    outline: none;
    border-color: #1e88e5;
    box-shadow: 0 0 0 3px rgba(30, 136, 229, 0.15);
  }

  .btn {
    width: 100%;
    background: #1e88e5;
    color: white;
    font-weight: bold;
    padding: 10px 12px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: 0.3s;
    box-sizing: border-box;
  }

  .btn:hover {
    background: #1565c0;
  }

  .note {
    margin-top: 10px;
    text-align: center;
    font-size: 13px;
    color: #555;
  }
  </style>
</head>
<body>
  <div class="card">
    <h2>Login</h2>

    <?php if ($blocked_message): ?>
      <div class="error"><?= htmlspecialchars($blocked_message) ?></div>
    <?php endif; ?>

    <?php if ($error && !$blocked_message): ?>
      <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="proses_login.php" method="post" autocomplete="off" novalidate>
      <div>
        <label for="username">Username</label>
        <input id="username" name="username" type="text" maxlength="100" required autofocus />
      </div>

      <div>
        <label for="password">Password</label>
        <input id="password" name="password" type="password" maxlength="100" required />
      </div>

      <button class="btn" type="submit">Masuk</button>
    </form>

    <div class="note">
      <p>Gunakan username dan password yang sesuai dengan data.</p>
    </div>
  </div>
</body>
</html>