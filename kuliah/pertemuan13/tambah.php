<?php

session_start();

if (!isset($_SESSION['login'])) {
  header("location: login.php");
  exit;
}

require 'functions.php';

// cek apakah tombol tambah sudah di tekan
if (isset($_POST['tambah'])) {
  if (tambah($_POST) > 0 ) {
    echo "<script>
            alert('Data berhasil ditambahkan');
            document.location.href = 'index.php';
          </script>";
  } else {
    echo "Data gagal ditambahkan!";
  }
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Mahasiswa</title>
  </head>
  <body>
      <h3>Tambah Data Mahasiswa</h3>
        <form action="" method="post" enctype="multipart/form-data">
          <ul>
            <li>
              <label for="nik">Nik : </label>
              <input type="number" name="nik" id="nik" autofocus required>
            </li>
            <li>
              <label for="nama">Nama : </label>
              <input type="text" name="nama" id="nama" required>
            </li>
            <li>
              <label for="email">Email : </label>
              <input type="email" name="email" id="email" required>
            </li>
            <li>
              <label for="bagian">Bagian : </label>
              <input type="text" name="bagian" id="bagian" required>
            </li>
            <li>
              <label for="departemen">Departemen : </label>
              <input type="text" name="departemen" id="departemen" required>
            </li>
            <li>
              <!-- <label for="gambar">Gambar : </label>
              <input type="file" name="gambar" > -->
              <label for="gambar">
                Gambar : 
                <input type="file" name="gambar" class="gambar" onchange="previewImage()">
              </label>
              <img src="images/default.jpg" class="img-preview" width="120" style="display: block;" alt="default">
            </li>
            <li>
              <button type="submit" name="tambah">Tambah Data</button>
            </li>
          </ul>
        </form>

        <script src="js/script.js"></script>
  </body>
</html>