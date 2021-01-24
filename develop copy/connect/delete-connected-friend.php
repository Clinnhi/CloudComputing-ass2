<?php
session_start();
require '../functions/dynamodb_functions.php';
$app = new DynamoDBFunctions();

if(isset($_POST["targetname"]))
{
    $result = $app->DeleteFriend($_SESSION['username'], $_POST["targetname"]);
}

header("Location: connect-list.php");
?>