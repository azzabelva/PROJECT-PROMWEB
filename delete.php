<?php
include "connect.php";
$idKamar = $_GET["id"];
mysqli_query($conn, "DELETE FROM kamar WHERE id_kamar='$idKamar'");
header("Location: view.php");
?>