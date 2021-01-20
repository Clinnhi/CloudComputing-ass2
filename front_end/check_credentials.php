<?php

session_start();

$username = $_POST["username"];
$password = $_POST["password"];

$error = "Username or Password Is Incorrect";

if($username == "admin" and $password == "admin"){
    $_SESSION["username"] = $username;
    $_SESSION["password"] = $password;
    header("location: about-me.php"); //send user to homepage, for example.
}else{
    $_SESSION["error"] = $error;
    header("location: loginpage.php"); //send user back to the login page.
}

?>