<?php

$host = "localhost";
$user = "root"; 
$pass = "";     
$db = "db_manajemen_proyek"; 

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi ke database gagal! Cek konfigurasi di 'config/koneksi.php'.<br>" 
        . "Error: (" . $conn->connect_errno . ") " . $conn->connect_error);
}

$conn->set_charset("utf8");

?>