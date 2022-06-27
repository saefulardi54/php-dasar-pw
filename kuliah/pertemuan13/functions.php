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

function upload() 
{
  $nama_file = $_FILES['gambar']['name'];
  $tipe_file = $_FILES['gambar']['type'];
  $ukuran_file = $_FILES['gambar']['size'];
  $error = $_FILES['gambar']['error'];
  $tmp_file = $_FILES['gambar']['tmp_name'];

  // ketika  tidak ada gambar
  if ($error == 4) {
    // echo "<script>
    //         alert('Gambar harus di isi!');
    //         document.location.href = 'tambah.php';
    //       </script>";
    // return false;
    return 'default.jpg';
  }

  // cek ekstensi file
  $daftar_gambar = ['jpg', 'jpeg', 'png'];
  $ekstensi_file = explode('.', $nama_file);
  $ekstensi_file = strtolower(end($ekstensi_file));
  if (!in_array($ekstensi_file, $daftar_gambar)) {
    echo "<script>
            alert('yang anda pilih bukan gambar!');
            document.location.href = 'tambah.php';
          </script>";
    return false;
  }

  // cek type file
  if ($tipe_file != 'image/jpeg' && $tipe_file != 'image/png') {
    echo "<script>
            alert('yang anda pilih bukan gambar!');
            document.location.href = 'tambah.php';
          </script>";
    return false;
  }

  // cek ukuran gambar
  // maksimal 5mb = 5.000.000 byte
  if ($ukuran_file > 5000000) {
    echo "<script>
            alert('Ukuran terlalu besar');
            document.location.href = 'tambah.php';
          </script>";
    return false;  
  }

  // upload file
  // generate nama file baru
  $nama_file_baru = uniqid();
  $nama_file_baru .= '.';
  $nama_file_baru .= $ekstensi_file;
  move_uploaded_file($tmp_file, 'images/' . $nama_file_baru);
  
  return $nama_file_baru;
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
  // $gambar = htmlspecialchars($data['gambar']);

  $gambar = upload();

  if (!$gambar) {
    return false;
  }

  $query = "INSERT INTO karyawan VALUES 
            (null, '$nik', '$nama', '$email', '$bagian', '$departemen','$gambar')";

  mysqli_query($conn, $query) or die(mysqli_error($conn));

  // mengembalikan pesan errro dari koneksi
  echo mysqli_error($conn);

  // memberi informasi jika ada  data yang berubah di database
  return mysqli_affected_rows($conn);
}

function hapus($id) 
{
  //koneksi database
  $conn = koneksi();

  // menghapus gambar di folder images
  $karyawan = query("SELECT * FROM karyawan WHERE id = $id");
  if ($karyawan['gambar'] != 'default.jpg') {
    unlink('images/' . $karyawan['gambar']);
  }

  // hapus berdasarkan id
  mysqli_query($conn, "DELETE FROM karyawan WHERE id = $id") or die (mysqli_error($conn));
  
  // memberi informasi jika ada  data yang berubah di database
  return mysqli_affected_rows($conn);
}

function edit($data)
{
  // var_dump($data);
  //koneksi ke database
  $conn = koneksi();  

  $id = $data['id'];
  $nik = htmlspecialchars($data['nik']);
  $nama = htmlspecialchars($data['nama']);
  $email = htmlspecialchars($data['email']);
  $bagian = htmlspecialchars($data['bagian']);
  $departemen = htmlspecialchars($data['departemen']);
  $gambar_lama = htmlspecialchars($data['gambar_lama']);

  $gambar = upload();

  if (!$gambar) {
    return false;
  }

  if ($gambar == 'default.jpg') {
    $gambar = $gambar_lama;
  }

  $query = "UPDATE karyawan SET 
            nik = '$nik',
            nama = '$nama',
            email = '$email',
            bagian = '$bagian',
            departemen = '$departemen',
            gambar = '$gambar'
            WHERE id = $id";

  mysqli_query($conn, $query) or die(mysqli_error($conn));

  // memberi informasi jika ada  data yang berubah di database
  return mysqli_affected_rows($conn);
}

function cari($keyword) {

  //koneksi
  $conn = koneksi();

  $query = "SELECT * FROM karyawan WHERE 
            nik LIKE '%$keyword%' OR
            nama LIKE '%$keyword%'";

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
