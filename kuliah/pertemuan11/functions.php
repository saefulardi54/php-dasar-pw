<?php

function koneksi()
{
  // koneksi ke Database 
  return mysqli_connect('localhost', 'root', '', 'db_php-dasar-pw');
}

function query($query)
{
  $conn = koneksi();

  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) == 1) {
    return mysqli_fetch_assoc($result);
  }

  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }

  return $rows;
}

function tambah($data)
{
  // var_dump($data);
  //koneksi ke database
  $conn = koneksi();  

  $nik = htmlspecialchars($data['nik']);
  $nama = htmlspecialchars($data['nama']);
  $email = htmlspecialchars($data['email']);
  $bagian = htmlspecialchars($data['bagian']);
  $departemen = htmlspecialchars($data['departemen']);
  $gambar = htmlspecialchars($data['gambar']);

  $query = "INSERT INTO karyawan VALUES 
            (null, '$nik', '$nama', '$email', '$bagian', '$departemen','$gambar')";

  mysqli_query($conn, $query) or die(mysqli_error($conn));

  // mengembalikan pesan errro dari koneksi
  echo mysqli_error($conn);

  // memberi informasi jika ada  data yang berubah di database
  return mysqli_affected_rows($conn);
}

function hapus($id) {
  //koneksi database
  $conn = koneksi();
  mysqli_query($conn, "DELETE FROM karyawan WHERE id = $id") or die (mysqli_error($conn));
  
  // memberi informasi jika ada  data yang berubah di database
  return mysqli_affected_rows($conn);
}

function edit($data)
{
  // var_dump($data);
  //koneksi ke database
  $conn = koneksi();  

  $id = htmlspecialchars($data['id']);
  $nik = htmlspecialchars($data['nik']);
  $nama = htmlspecialchars($data['nama']);
  $email = htmlspecialchars($data['email']);
  $bagian = htmlspecialchars($data['bagian']);
  $departemen = htmlspecialchars($data['departemen']);
  $gambar = htmlspecialchars($data['gambar']);

  $query = "UPDATE karyawan SET 
            nik = '$nik',
            nama = '$nama',
            email = '$email',
            bagian = '$bagian',
            departemen = '$departemen'
            WHERE id = $id";

  mysqli_query($conn, $query) or die(mysqli_error($conn,));

  // memberi informasi jika ada  data yang berubah di database
  return mysqli_affected_rows($conn);
}

function cari($keyword) {

  //koneksi
  $conn = koneksi();

  $query = "SELECT * FROM karyawan WHERE 
            nik LIKE '%$keyword%' OR
            nama LIKE '%$keyword%' OR
            email LIKE '%$keyword%' OR
            bagian LIKE '%$keyword%' OR
            departemen LIKE '%$keyword%' OR";
  
  $result = mysqli_query($conn, $query);

  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }

  return $rows;
}

?>
