<?php
session_start();
require 'functions/dynamodb_functions.php';
$app = new DynamoDBFunctions();

if(isset($_POST["targetname"]))
{
    $result = $app->AcceptFriendRequest($_SESSION['username'], $_POST["targetname"], true);
    header("Location: connect-request-list.php");

}
?>