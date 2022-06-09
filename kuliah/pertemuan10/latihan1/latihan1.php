<?php

  // koneksi ke Database 
  $db = mysqli_connect('localhost', 'root', '', 'db_php-dasar-pw');


  // query isi table karyawan
  $result = mysqli_query($db, "SELECT * FROM karyawan");

  // ubah data kedalam array
  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }

  // simpan semua data kedalam variable karyawan
  $karyawan = $rows;

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

    <table border="1" cellpadding="10" cellspacing="0">

      <tr>
        <th>#</th>
        <th>Gambar</th>
        <th>NIK</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Bagian</th>
        <th>Departemen</th>
        <th>Aksi</th>
      </tr>

      <?php $i = 1; ?>
      <?php foreach($karyawan as $ky) : ?>
      <tr>
        <td><?= $i++; ?></td>
        <td><img src="../images/<?= $ky['gambar']?>" width="80px"></td>
        <td><?= $ky['nik']?></td>
        <td><?= $ky['nama']?></td>
        <td><?= $ky['email']?></td>
        <td><?= $ky['bagian']?></td>
        <td><?= $ky['departemen']?></td>
        <td>
          <a href="">Edit</a> | <a href="">Hapus</a>
        </td>
      </tr> 
      <?php endforeach ; ?>

    </table>
    
  </body>
</html>