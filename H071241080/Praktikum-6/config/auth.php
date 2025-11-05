<?php
session_start();
include('koneksi.php');

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header("Location: ../index.php");
    exit;
}

function checkRole($roles = []) {
    if (!in_array($_SESSION['role'], $roles)) {
        header("Location: ../index.php");
        exit;
    }
}
?>
