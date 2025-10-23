<?php
/*
 * File: logout.php
 * Deskripsi: Menghapus session dan mengarahkan ke halaman login.
 */

require_once 'config.php';

// Hapus semua variabel session
$_SESSION = array();

// Hancurkan session
session_destroy();

// Arahkan kembali ke halaman login
header("location: login.php");
exit;
?>