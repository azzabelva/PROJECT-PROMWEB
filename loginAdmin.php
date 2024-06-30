<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UT-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Login Admin</title>
        <link rel="stylesheet" href="login.css">
    </head>
    <body>
        <div class="container">
            <div class="login">
                <form action="loginAdmin.php" method="post">
                    <h1>Login</h1>
                    <hr>
                    <p>Ocean Hotel Admin Page</p>
                    <label for="usn_admin">Username</label>
                    <input type="text" name="usn_admin" id="usn_admin" placeholder="admin1_">
                    <label for="pass_admin">Password</label>
                    <input type="password" name="pass_admin" id="pass_admin" placeholder="Password">
                    <button type="=submit" name="login">Login</button>
                    <p>
                        Masuk sebagai customer
                        <a href="loginAdmin.php">Login</a>
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
    $username = $_POST["usn_admin"];
    $password = $_POST["pass_admin"];
    
$select = mysqli_query($conn, "SELECT * FROM admin WHERE usn_admin = '$username'
AND pass_admin = '$password'");
$row = mysqli_fetch_array($select);

if(is_array($row)){
    $_SESSION["usn_admin"] = $row["usn_admin"];
    $_SESSION["pass_admin"] = $row["pass_cadmin"];
} else {
    echo "<script type='text/javaScript'>";
    echo "alert('invalid username or password')";
    echo "window.location.href = loginAdmin.php";
    echo "</script>";
}
}
if(isset($_SESSION["usn_admin"])) {
    header("Location: view.php");
}
?>