<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UT-8" />
    <meta name="viewport" content="width=device-width, initial-scale 1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Homepage</title>
    <link rel="stylesheet" href="home.css" />
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
        <div class="text_center">CHECK AVAILABILITY</div>
      </div>
      <div class="rooms">
        <h1>DISCOVER OUR ROOMS</h1>
        <?php
        //koneksi database
        include "connect.php";

        error_reporting(E_ALL^E_DEPRECATED^E_WARNING);

        echo $_SESSION['usn_customer'];
        //mengambil data dari database
        $query = mysqli_query($conn, "SELECT * FROM `kamar`");

        //menampilkan data dari database
        while($data = mysqli_fetch_array($query)){
        ?>
        <div class="display">
          <div class="left">
            <img src="upload/<?= $data['gambar_kamar']; ?>" alt="" />
          </div>
          <div class="right">
            <br>
            <h2><?= $data['tipe_kamar']; ?></h2>
            <h3>Rp. <?= $data['harga_kamar']; ?>/night</h3>
            <hr>
            <p><?= $data['keterangan']; ?></p>
            <input type="hidden" name="id_kamar" value="<?= $data['id_kamar']; ?>">
            <input type="hidden" name="id_adminFK" value="<?= $data['id_adminFK']; ?>">
            <a href="booking.php?id=<?= $data['id_kamar']; ?>"><button type="submit" name="booking">BOOK NOW</button></a>
          </div>
        </div>
        <?php } ?>
      </div>
    </div>
  </body>
</html>