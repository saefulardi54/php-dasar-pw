<?php
require 'functions.php';

$karyawan = query("SELECT * FROM karyawan");

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Karyawan</title>
  </head>
  <body>
    <h1>Daftar Karyawan</h1>

    <a href="tambah.php">Tambah Data Karyawan</a>

    <br></br>

    <table border="1" cellpadding="10" cellspacing="0">

      <tr>
        <th>#</th>
        <th>Gambar</th>
        <th>NIK</th>
        <th>Nama</th>
        <th>Aksi</th>
      </tr>

      <?php $i = 1; ?>
      <?php foreach($karyawan as $ky) : ?>
      <tr>
        <td><?= $i++; ?></td>
        <td><img src="../images/<?= $ky['gambar']?>" width="80px"></td>
        <td><?= $ky['nik']?></td>
        <td><?= $ky['nama']?></td>
        <td>
          <a href="detail.php?id=<?= $ky['id']?>">Detail</a>
        </td>
      </tr> 
      <?php endforeach ; ?>

    </table>
    
  </body>
</html>