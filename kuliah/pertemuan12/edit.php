<?php

session_start();

if (!isset($_SESSION['login'])) {
  header("location: login.php");
  exit;
}

require 'functions.php';

// ambil id dadri ur
$id = $_GET['id'];

// jika tidak ada id di url
if (!isset($_GET['id'])) {
  header("location: index.php");
  exit;
}

//queru karyawan berdasarkan id
$karyawan = query("SELECT * FROM karyawan WHERE id = $id");

// cek apakah tombol edit sudah di tekan
if (isset($_POST['edit'])) {
  if (edit($_POST) > 0 ) {
    echo "<script>
            alert('Data berhasil diupdate');
            document.location.href = 'index.php';
          </script>";
  } else {
    echo "Data gagal diupdate!";
  }
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Mahasiswa</title>
  </head>
  <body>
      <h3>Edit Data Mahasiswa</h3>
        <form action="" method="post">
          <input type="hidden" name="id" value="<?= $karyawan['id']; ?>">
          <ul>
            <li>
              <label for="nik">Nik : </label>
              <input type="number" name="nik" id="nik" autofocus required value="<?= $karyawan['nik'] ?>">
            </li>
            <li>
              <label for="nama">Nama : </label>
              <input type="text" name="nama" id="nama" required value="<?= $karyawan['nama'] ?>">
            </li>
            <li>
              <label for="email">Email : </label>
              <input type="email" name="email" id="email" required value="<?= $karyawan['email'] ?>">
            </li>
            <li>
              <label for="bagian">Bagian : </label>
              <input type="text" name="bagian" id="bagian" required value="<?= $karyawan['bagian'] ?>">
            </li>
            <li>
              <label for="departemen">Departemen : </label>
              <input type="text" name="departemen" id="departemen" required value="<?= $karyawan['departemen'] ?>">
            </li>
            <li>
              <label for="gambar">Foto : </label>
              <input type="text" name="gambar" required value="<?= $karyawan['nik'] ?>">
            </li>
            <li>
              <button type="submit" name="edit">Edit Data</button>
            </li>
          </ul>
        </form>
  </body>
</html>