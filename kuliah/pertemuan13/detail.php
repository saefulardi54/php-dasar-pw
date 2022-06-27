<?php

session_start();

if (!isset($_SESSION['login'])) {
  header("location: login.php");
  exit;
}

require 'functions.php';

// ambil id dari url
$id = $_GET['id'];

// query karyawan berdasarkan id
$karyawan = query("SELECT * FROM karyawan WHERE id = $id");

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Karyawan</title>
  </head>
  <body>
    <h3>Detail Karyawan</h3>
    <ul>
      <li><img src="images/<?= $karyawan['gambar']; ?>" width="250px"></li>
      <li>Nik :<?= $karyawan['nik']; ?></li>
      <li>Nama :<?= $karyawan['nama']; ?></li>
      <li>Email :<?= $karyawan['email']; ?></li>
      <li>Bagian :<?= $karyawan['bagian']; ?></li>
      <li>Departemen :<?= $karyawan['departemen']; ?></li>
      <li><a href="edit.php?id=<?= $karyawan['id']; ?>">Edit</a> | <a href="hapus.php?id=<?= $karyawan['id']?>" onclick="return confirm('Anda yakin ?');">Hapus</a></li> 
      <li><a href="index.php">Kembali</a></li>
    </ul>
  </body>
</html>