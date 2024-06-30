<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UT-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Login Page</title>
        <link rel="stylesheet" href="login.css">
    </head>
    <body>
        <div class="container">
            <div class="login">
                <form action="login.php" method="post">
                    <h1>Login</h1>
                    <hr>
                    <p>Ocean Hotel</p>
                    <label for="usn_costumer">Username</label>
                    <input type="text" name="usn_customer" id="usn_customer" placeholder="Username">
                    <label for="pass_customer">Password</label>
                    <input type="password" name="pass_customer" id="pass_customer" placeholder="Password">
                    <button type="=submit" name="login">Login</button>
                    <p>
                        Belum memiliki akun <a href="a">Sign Up</a>
                        </br>
                        Masuk sebagai admin <a href="b">Admin</a>
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
include "connect.php";
if(isset($_POST["login"])){
    $username = $_POST["usn_customer"];
    $password = $_POST["pass_customer"];
    
$select = mysqli_query($conn, "SELECT * FROM customer WHERE usn_customer = '$username'
AND pass_customer = '$password'");
$row = mysqli_fetch_array($select);

if(is_array($row)){
    $_SESSION["usn_customer"] = $row["usn_customer"];
    $_SESSION["pass_customer"] = $row["pass_customer"];
} else {
    echo "<script type='text/javaScript'>";
    echo "alert('invalid username or password')";
    echo "window.location.href = login.php";
    echo "</script>";
}
}
if(isset($_SESSION["usn_customer"])) {
    header("Location: home.php");
}
?>