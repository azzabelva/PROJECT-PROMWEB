<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UT-8">
        <meta name="viewport" content="width=device-width, initial-scale 1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Booking A Room</title>
        <link rel="stylesheet" href="booking.css">
    </head>
    <body>
        <div class="container">
            <div class="nav">
                <div class="logo">
                  <img src="logo.jpg" alt="" />
                </div>
                <div class="bar">
                  <a href="home.php">Home</a>
                  <a href="about.php">About Us</a>
                </div>
            </div>
            <div class="header">
                <img src="header.jpg" alt="" style="width: 100%">
                <div class="text_center">BOOKING ROOM</div>
            </div>
            <?php
            //koneksi database
            include "connect.php";

                    error_reporting(E_ALL^E_DEPRECATED^E_WARNING);

            //mendapatkan id kamar
            $id = $_GET["id"];
            //query menampilkan kamar
            $query = mysqli_query($conn, "SELECT * FROM `kamar` WHERE id_kamar='$id'");
            
            $harga = $_POST['harga_kamar'];
            $idTransaksi = $_POST['id_transaksi'];
            $idCustomer = $_POST['id_customer'];
            $idKamar = $_POST['id_kamar'];
            $tanggal_sewa = $_POST['tanggal_sewa'];
            $lama_sewa = $_POST['lama_sewa'];
            $tagihan_sewa = $_POST['tagihan_sewa'];
            //jika terdapat data maka akan ditampilkan
            while ($data = mysqli_fetch_assoc($query)) {
            ?>
            <div class="booking">
                <div class="left">
                    <img src="upload/<?= $data['gambar_kamar']; ?>" alt="" />
                    <h1><?= $data['tipe_kamar']; ?></h1>
                    <h3>Rp. <?= $data['harga_kamar']; ?>/night</h3>
                    <p><?= $data['keterangan']; ?></p>
                </div>
            <?php } ?>
                <div class="right">
                    <?php
                    $kamar = mysqli_query($conn, "SELECT id_kamar, tipe_kamar, harga_kamar FROM kamar WHERE id_kamar='$id'");
                    $cust = mysqli_query($conn, "SELECT id_customer, nama_customer FROM customer WHERE id_customer='$id'");
                    ?>
                    <div class="formulir">
                        <h2>BOOK A ROOM</h2>
                        <form action="booking.php?id=<?= $data['id_kamar']; ?>" method="post">
                            <label>Nama</label>
                            <?php
                            while ($data = mysqli_fetch_assoc($cust)) {
                            ?>
                            <input type="text" name="nama" id="nama" required value="<?= $data['nama_customer']; ?>" />
                            <input type="hidden" name="id_customer" value="<?= $data['id_customer']; ?>">
                            <?php } ?>
                            <label>Tanggal Sewa</label>
                            <input type="date" name="tanggal_sewa" id="tanggal_sewa" /required>
                            <label>Lama Sewa</label>
                            <input type="text" name="lama_sewa" id="lama_sewa" /required>
                            <label>Tipe Kamar</label>
                            <?php
                            while ($data = mysqli_fetch_assoc($kamar)) {
                            ?>
                            <input type="text" name="tipe_kamar" id="tipe" required value="<?= $data['tipe_kamar']; ?>" />
                            <input type="hidden" name="id_kamar" value="<?= $data['id_kamar']; ?>">
                            <input type="hidden" name="harga_kamar" value="<?= $data['harga_kamar']; ?>">
                            <?php } 
                            $tagihan = $lama_sewa * $harga; ?>
                            <input type="hidden" name="tagihan_sewa" value="<?php echo "$tagihan"; ?>">
                            <button type="submit" name="booking">BOOK TABLE</button>
                        </form>
                    </div>
                    <div class="contact">
                        <h3>If You Need Any Help
                            Contact With Us</h3>
                        <hr>
                        <h2>+92 705 2101 786</h2>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

<?php
include "connect.php";
if (isset($_POST['booking'])) {
    // Insert data ke dalam database
    $query = mysqli_query($conn, "INSERT INTO transaksi (id_transaksi, id_kamarFK, id_adminFK, tanggal_sewa, lama_sewa, tagihan_sewa) 
    VALUES ('', '$idCustomer', '$idKamar', '$tanggal_sewa' ,'$lama_sewa', '$tagihan_sewa')");
    if ($query) {
        echo "
        <script>
            alert('Kamar berhasil dipesan dengan total tagihan $tagihan');
            document.location.href = 'home.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Pesanan anda gagal');
            document.location.href = 'home.php';
        </script>
        ";
    }
}?>