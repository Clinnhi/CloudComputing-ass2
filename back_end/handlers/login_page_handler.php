<?php

session_start();
require 'vendor/autoload.php';

// data from POST method 
$input_username = trim($_POST['username']);
$input_password = trim($_POST['password']);

ob_start(); // begin collecting output

include 'functions/login.php';

$login = ob_get_clean(); // retrieve output from myfile.php, stop buffering
// echo $login;
if ($login == 1) {
    echo '<h1>login success! Welcome ' .$_SESSION['username']. '</h1>';
}
else {
    echo '<h1>login failed</h1>';
}

?>