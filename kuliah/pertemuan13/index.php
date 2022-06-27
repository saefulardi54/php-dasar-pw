<?php

session_start();

// jika variabel login(session) ada maka lanjut login
if (!isset($_SESSION['login'])) {
  header("location: login.php");
  exit;
}

require 'functions.php';

$karyawan = query("SELECT * FROM karyawan");

// ketika tombol cari di klik
if (isset($_POST['cari'])) {
  $karyawan = cari($_POST['keyword']);
}

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
    <a href="logout.php">Logout</a>
    <h1>Daftar Karyawan</h1>
    
    <a href="tambah.php">Tambah Data Karyawan</a>

    <form action="" method="POST">
      <input type="text" class="keyword" name="keyword" size="40" 
        placeholder="Masukan keyword pencarian" autocomplete="off" autofocus>
      <button type="submit" name="cari" class="tombol-cari">Cari!</button>
    </form>

    <br>
    <div class="container">
      <table border="1" cellpadding="10" cellspacing="0">
        <tr>
          <th>#</th>
          <th>Gambar</th>
          <th>NIK</th>
          <th>Nama</th>
          <th>Aksi</th>
        </tr>

        <?php if(empty($karyawan)) : ?>
          <tr>
            <td colspan="5">
              <p>
                Data Karyawan tidak ditemukan!
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
    </div>
    
    <script src="js/script.js"></script>
  </body>
</html>


