<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            <div class="text_center">UPDATE ROOM</div>
        </div>
        <div class="box">
            <div class="formulir">
                <?php
                //koneksi database
                include "connect.php";

                //mengambil id kamar
                $idKamar = $_GET["id"];
                
                //mengambil data untuk ditampilkan
                $query = mysqli_query($conn, "SELECT * FROM kamar WHERE id_kamar = '$idKamar'");

                //jika terdapat data maka akan ditampilkan
                while ($data = mysqli_fetch_assoc($query)) {
                ?>
                <h1>UPDATE ROOM</h1>
                <form action="edit.php?id=<?= $data['id_kamar']; ?>" enctype="multipart/form-data" method="post">
                    <label>Id Kamar</label>
                    <input type="text" name="id_kamar" value="<?= $data['id_kamar']; ?>" readonly>
                    <label>Id Admin</label>
                    <?php
                    $sqlAdmin = "SELECT * FROM admin";
                    $resultAdmin = mysqli_query($conn, $sqlAdmin);
                    echo "<select name='id_admin'>";
                    while ($rowAdmin = mysqli_fetch_array($resultAdmin)) {
                        $selected = ($rowAdmin['id_admin'] == $data['id_adminFK']) ? 'selected' : '';
                        echo "<option value='$rowAdmin[id_admin]' $selected>$rowAdmin[id_admin]</option>";
                    }
                    echo "</select>";
                    ?>
                    <label>Harga Kamar</label>
                    <input type="text" name="harga_kamar" required value="<?= $data['harga_kamar']; ?>" />
                    <label>Tipe Kamar</label>
                    <input type="text" name="tipe_kamar" required value="<?= $data['tipe_kamar']; ?>" />
                    <label>Keterangan Kamar</label>
                    <input type="text" name="keterangan" required value="<?= $data['keterangan']; ?>" />
                    <label>Gambar Kamar</label>
                    <img src="upload/<?= $data['gambar_kamar']; ?>" width="40">
                    <input type="file" name="gambar">
                    <button type="submit" name="update">UPDATE ROOM</button>
                </form>
                <?php } ?>
            </div>
        </div>
    </div>
</body>
</html>

<?php
//jika submit ditekan maka proses update data dilakukan
if (isset($_POST['update'])) {
    $idKamar = $_POST['id_kamar'];
    $idAdmin = $_POST['id_admin'];
    $harga = $_POST['harga_kamar'];
    $tipe = $_POST['tipe_kamar'];
    $keterangan = $_POST['keterangan'];

    // cek jika user mengubah gambar
    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $_POST['gambar'];
    } else {
        $gambar = upload();
    }

    //update data
    $queryUpdate = "UPDATE kamar SET id_adminFK='$idAdmin', harga_kamar='$harga', tipe_kamar='$tipe',
                    keterangan='$keterangan', gambar_kamar='$gambar' WHERE id_kamar='$idKamar'";
    mysqli_query($conn, $queryUpdate);

    //kembali ke halaman view
    header("Location: view.php");
    exit();
}

//memuat fungsi upload
function upload(){
$namaFile = $_FILES['gambar']['name'];
$ukuranFile = $_FILES['gambar']['size'];
$error = $_FILES['gambar']['error'];
$tmpName = $_FILES['gambar']['tmp_name'];
//cek apakah gambar sudah diupload
if ($error === 4) {
echo "<script>
alert('gambar belum diupload');
</script>";
return false;
}
//cek apakah benar ekstensi gambar yang diupload
$ekstensiGambarValid = ['jpeg', 'jpg', 'png'];
$ekstensiGambar = explode('.', $namaFile);
$ekstensiGambar = strtolower(end($ekstensiGambar));
if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
echo "<script>
alert('ekstensi gambar yang diperbolehkan adalah jpeg, jpg, png');
</script>";
return false;
}
//cek jika size melebihi yang diperbolehkan
if ($ukuranFile > 500000) {
echo "<script>
alert('gambar melebihi ukuran yang diperbolehkan');
</script>";
return false;
}
//lolos pengecekan, file dimasukkan ke dalam database
//buat nama file menjadi unik
$namaFileBaru = uniqid();
$namaFileBaru .= '.';
$namaFileBaru .= $ekstensiGambar;
move_uploaded_file($tmpName, 'upload/' . $namaFileBaru);
return $namaFileBaru;
}
?>