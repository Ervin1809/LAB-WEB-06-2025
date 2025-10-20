<?php
session_start();

// Hapus semua data session
session_unset();
session_destroy();

// Hapus cookie session
setcookie(session_name(), '', time() - 3600, '/');

header('Location: login.php');
exit;
