<?php

require 'functions.php';

// ambil id dari url
$id = $_GET['id'];

// query karyawan berdasarkan id
$karyawan = query("SELECT * FROM karyawan WHERE id = $id");
var_dump($karyawan);
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
      <li><img src="../images/<?= $karyawan['gambar']; ?>" width="80px"></li>
      <li><?= $karyawan['nik']; ?></li>
      <li><?= $karyawan['nama']; ?></li>
      <li><?= $karyawan['email']; ?></li>
      <li><?= $karyawan['bagian']; ?></li>
      <li><?= $karyawan['departemen']; ?></li>
      <li><a href="">Edit</a> | <a href="">Hapus</a></li> 
      <li><a href="latihan3.php">Kembali</a></li>
    </ul>
  </body>
</html>