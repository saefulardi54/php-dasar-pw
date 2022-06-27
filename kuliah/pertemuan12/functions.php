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
  $username = htmlspecialchars($data['username']);
  $bagian = htmlspecialchars($data['bagian']);
  $departemen = htmlspecialchars($data['departemen']);
  $gambar = htmlspecialchars($data['gambar']);

  $query = "INSERT INTO karyawan VALUES 
            (null, '$nik', '$nama', '$username', '$bagian', '$departemen','$gambar')";

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
  $username = htmlspecialchars($data['username']);
  $bagian = htmlspecialchars($data['bagian']);
  $departemen = htmlspecialchars($data['departemen']);
  $gambar = htmlspecialchars($data['gambar']);

  $query = "UPDATE karyawan SET 
            nik = '$nik',
            nama = '$nama',
            username = '$username',
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
            username LIKE '%$keyword%' OR
            bagian LIKE '%$keyword%' OR
            departemen LIKE '%$keyword%' OR";
  
  $result = mysqli_query($conn, $query);

  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }

  return $rows;
}

function login($data)
{
  // koneksi ke database 
  $conn = koneksi();

  // data di ambil dari form login
  $username = htmlspecialchars($data['username']);
  $password = htmlspecialchars($data['password']);

  // cek username
  if ($user = query("SELECT * FROM user WHERE username = '$username'")) {
    // cek password
    if (password_verify($password, $user['password'])) {
      // set session
      // jika login berhasil maka akan ada sebuah session yang bernama login
      $_SESSION['login'] = true;

      header("location: index.php");
      exit;
    }
  }
  return [
    'error' => true,
    'pesan' => 'Username atau Password Anda Salah!'
  ];
}

function registrasi($data)
{
  // koneksi
  $conn = koneksi();

  // mengambil data dari form registrasi
  $username = htmlspecialchars(strtolower($data['username']));
  $password1 = mysqli_real_escape_string($conn, $data['password1']);
  $password2 = mysqli_real_escape_string($conn, $data['password2']);

  // jika username atau password kosong
  if (empty($username) || empty($password1) || empty($password2)) {
    echo "<script>
            alert('username atau password tidak boleh kosong');
            document.location.href = 'registrasi.php';
          </script>";
    return false;
  }

  // username sudah terdaftar
  if (query("SELECT * FROM user WHERE username = '$username'")) {
    echo "<script>
            alert('username atau password sudah terdaftar');
            document.location.href = 'registrasi.php';
          </script>";
    return false;
  }

  // jika konfirmasi password tidak sama
  if ($password1 !== $password2) {
    echo "<script>
            alert('Konfirmasi password tidak sesuai');
            document.location.href = 'registrasi.php';
          </script>";
    return false;
  }

  // password
  if (strlen($password1) < 5) {
    echo "<script>
            alert('Password terlalu pendek');
            document.location.href = 'registrasi.php';
          </script>";
    return false;
  }

  // jika username & password sudah sesuai
  // enkripsi password dengan enkripsi password terbaru 
  $password_baru = password_hash($password1, PASSWORD_DEFAULT);

  // insert ke tabel user
  $query = "INSERT INTO user VALUES (null, '$username', '$password_baru')";
  mysqli_query($conn, $query) or die(mysqli_error($conn));

  return mysqli_affected_rows($conn);



}

?>
