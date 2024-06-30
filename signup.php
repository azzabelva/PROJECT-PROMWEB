<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up Page</title>
    <link rel="stylesheet" href="signup.css">
</head>

<body>
    <div class="container">
        <div class="login">
            <form action="signup.php" method="post">
                <h1>Sign Up</h1>
                <hr>
                <p>Ocean Hotel</p>
                <label for="">Nama</label>
                <input type="text" name="nama_customer" id="nama_customer" placeholder="Ocean" required>
                <label for="">Username</label>
                <input type="text" name="usn_customer" id="usn_customer" placeholder="Ocean_" required>
                <label for="">Password</label>
                <input type="password" name="pass_customer" id="pass_customer" placeholder="Password" required>
                <label for="">Repeat Password</label>
                <input type="password" name="repeat_password" id="repeat_password" placeholder="Repeat Password" required>
                <label for="">No. Handphone</label>
                <input type="text" name="kontak" id="kontak" placeholder="081xxxxx" required>
                <label for="">Email</label>
                <input type="email" name="email" id="email" placeholder="example@gmail.com" required>
                <button type="submit" name="submit">Sign Up</button>
                <p>
                    Sudah memiliki akun <a href="a">Login</a>
                </p>
            </form>
        </div>
        <div class="right">
            <img src="logo.png" alt="">
        </div>
    </div>
</body>

</html>
<?php
include("connect.php");

if(isset($_POST['submit'])){
    $nama = $_POST['nama_customer'];
    $username = $_POST['usn_customer'];
    $password = $_POST['pass_customer'];
    $kontak = $_POST['kontak'];
    $email = $_POST['email'];

    $sql = "SELECT * FROM customer WHERE usn_customer = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result_user = mysqli_stmt_get_result($stmt);
    $count_user = mysqli_num_rows($result_user);

    $sql = "SELECT * FROM customer WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result_email = mysqli_stmt_get_result($stmt);
    $count_email = mysqli_num_rows($result_email);

    if($count_user == 0 && $count_email == 0){
        $sql = "INSERT INTO customer (nama_customer, usn_customer, pass_customer, kontak, email) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssss", $nama, $username, $password, $kontak, $email);
        mysqli_stmt_execute($stmt);

        echo '<script>alert("Successfully signed up");</script>';
        echo '<script>window.location.href="login.php";</script>';
        exit;
    } else {
        if($count_user > 0){
            echo '<script>alert("Username already exists");</script>';
        }
        if($count_email > 0){
            echo '<script>alert("Email already exists");</script>';
        }
        echo '<script>window.location.href="login.php";</script>';
        exit;
    }
}
?>