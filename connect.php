<?php
//isi nama host, username mysql, dan password mysql
$server = "localhost";
$user = "root";
$pass = "";
$nama_database = "db_hotel";

//isikan dengan nama database yang akan di hubungkan
$conn = mysqli_connect($server, $user, $pass, $nama_database);

if (!$conn){
    die("Gagal terhubung dengan database: ". mysqli_connect_error());
};
?>