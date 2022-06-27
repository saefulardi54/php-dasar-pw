<?php

require '../functions.php';
$karyawan = cari($_GET['keyword']);

?>

<table border="1" cellpadding="10" cellspacing="0">
  <tr>
    <th>#</th>
    <th>Gambar</th>
    <th>NIK</th>
    <th>Nama</th>
    <th>Aksi</th>
  </tr>

  <?php if (empty($karyawan)) : ?>
    <tr>
      <td colspan="5">
        <p>
          Data karyawan tidak ditemukan!
        </p>
      </td>
    </tr>
  <?php endif ; ?>

  <?php $i = 1; ?>
  <?php foreach($karyawan as $k) : ?>
    <tr>
      <td><?= $i++; ?></td>
      <td><img src="images/<?= $k['gambar']?>" width="80px"></td>
      <td><?= $k['nik']?></td>
      <td><?= $k['nama']?></td>
      <td>
        <a href="detail.php?id=<?= $k['id']?>">Detail</a>
      </td>
    </tr> 
  <?php endforeach ; ?>
</table>