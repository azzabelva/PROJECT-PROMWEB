<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UT-8">
        <meta name="viewport" content="width=device-width, initial-scale 1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Admin Page</title>
        <link rel="stylesheet" href="insert.css">
    </head>
    <body>
        <div class="container">
            <div class="nav">
                <div class="logo">
                  <img src="logo.jpg" alt="" />
                </div>
                <div class="bar">
                  <a href="#">Home</a>
                  <a href="#">About Us</a>
                </div>
            </div>
            <div class="header">
                <img src="header.jpg" alt="" style="width: 100%">
                <div class="text_center">INSERT ROOM</div>
            </div>
            <div class="box">
                <div class="formulir">
                    <h1>INSERT ROOM</h1>
                    <form action="insert.php" enctype="multipart/form-data" method="post">
                        <label>Id Admin</label>
                        <?php
                        include "connect.php";
                        $sql = "select * from admin";
                        $retval = mysqli_query($conn, $sql);
                        echo "<select name='id_admin'>";
                        while ($row = mysqli_fetch_array($retval)){
                            echo "<option value='$row[id_admin]'>$row[id_admin]</option>";
                        }
                        echo"</select>";
                        ?>
                        <label>Harga Kamar</label>
                        <input type="text" name="harga" id="harga" /required>
                        <label>Tipe Kamar</label>
                        <input type="text" name="tipe" id="tipe" /required>
                        <label>Keterangan Kamar</label>
                        <input type="text" name="keterangan" id="keterangan" /required>
                        <label>Gambar Kamar</label>
                        <input type="file" name="gambar" id="gambar" /required>
                        <button type="submit" name="insert">INSERT ROOM</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
<?php
// Melakukan koneksi ke database
include 'connect.php';
// Jika tombol submit ditekan, proses tambah data dilakukan
error_reporting(E_ALL^E_DEPRECATED^E_WARNING);
if (isset($_POST['insert'])) {
    $idAdmin = $_POST['id_admin'];
    $harga = $_POST['harga'];
    $tipe = $_POST['tipe'];
    $keterangan = $_POST['keterangan'];
    $gambar = upload();
    // Jika gambar gagal upload
    if (!$gambar) {
        echo "<script>
            alert('Gambar gagal diupload');
        </script>";
        return;
    }
    // Insert data ke dalam database
    $query = mysqli_query($conn, "INSERT INTO kamar (id_kamar, id_adminFK, harga_kamar, tipe_kamar, keterangan, gambar_kamar) 
    VALUES ('', '$idAdmin', '$harga',  '$tipe', '$keterangan' ,'$gambar')");
    // Kembali ke halaman view
    if ($query) {
        echo "
        <script>
            alert('Data berhasil ditambahkan');
            document.location.href = 'view.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Data gagal ditambahkan');
            document.location.href = 'view.php';
        </script>
        ";
    }
}
function upload() {
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    // Cek apakah gambar sudah diupload
    if ($error === 4) {
        echo "<script>
            alert('Gambar belum diupload');
        </script>";
        return false;
    }

    // Cek apakah benar ekstensi gambar yang diupload
    $ekstensiGambarValid = ['jpeg', 'jpg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>
            alert('Ekstensi gambar yang diperbolehkan adalah jpeg, jpg, png');
        </script>";
        return false;
    }

    // Cek jika size melebihi yang diperbolehkan
    if ($ukuranFile > 500000) {
        echo "<script>
            alert('Gambar melebihi ukuran yang diperbolehkan');
        </script>";
        return false;
    }

    // Lolos pengecekan, file dimasukkan ke dalam database
    // Buat nama file menjadi unik
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;
    move_uploaded_file($tmpName, 'upload/' . $namaFileBaru);

    return $namaFileBaru;
}
?>