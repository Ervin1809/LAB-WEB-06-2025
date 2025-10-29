<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Project Manager') {
    die("Akses ditolak");
}

$id_tugas = $_GET['id'] ?? 0;
$project_id = $_GET['project_id'] ?? 0;
$manager_id = $_SESSION['user']['id'];

$sql = "DELETE t FROM tasks t
        JOIN projects p ON t.project_id = p.id
        WHERE t.id=? AND p.manager_id=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $id_tugas, $manager_id);
mysqli_stmt_execute($stmt);

header("Location: tugas_crud.php?project_id=" . $project_id);
exit();
