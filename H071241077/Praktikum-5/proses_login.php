<?php
// proses_login.php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}
if (!isset($_SESSION['first_attempt_time'])) {
    $_SESSION['first_attempt_time'] = time();
}
$max_attempts = 5;
$block_seconds = 60;

if (!empty($_SESSION['blocked_until']) && $_SESSION['blocked_until'] > time()) {
    $_SESSION['error'] = 'Akses diblok sementara karena percobaan login berulang.';
    header('Location: login.php');
    exit;
}

$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if ($username === '' || $password === '') {
    $_SESSION['error'] = 'Username dan password wajib diisi.';
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/data.php';

$foundUser = null;
foreach ($users as $u) {
    if (isset($u['username']) && $u['username'] === $username) {
        $foundUser = $u;
        break;
    }
}

if (!$foundUser) {
    $_SESSION['login_attempts'] += 1;
    if ($_SESSION['login_attempts'] >= $max_attempts) {
        $_SESSION['blocked_until'] = time() + $block_seconds;
        $_SESSION['login_attempts'] = 0;
    }

    $_SESSION['error'] = 'Username atau password salah!';
    header('Location: login.php');
    exit;
}

// verify password
$hashed = $foundUser['password'] ?? '';
if (!password_verify($password, $hashed)) {
    $_SESSION['login_attempts'] += 1;
    if ($_SESSION['login_attempts'] >= $max_attempts) {
        $_SESSION['blocked_until'] = time() + $block_seconds;
        $_SESSION['login_attempts'] = 0;
    }

    $_SESSION['error'] = 'Username atau password salah!';
    header('Location: login.php');
    exit;
}

// Jika lolos verifikasi, buat session user (bersihkan sensitive info)
session_regenerate_id(true);

$safeUser = $foundUser;
unset($safeUser['password']);

$_SESSION['user'] = $safeUser;

// reset attempt counter
unset($_SESSION['login_attempts'], $_SESSION['first_attempt_time'], $_SESSION['blocked_until']);


header('Location: dashboard.php');
exit;
