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

  if (mysqli_num_rows($result)) {
    return mysqli_fetch_assoc($result);
  }

  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }

  return $rows;
}

?>
