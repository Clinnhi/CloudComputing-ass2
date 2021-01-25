<?php
session_start();
require '../functions/dynamodb_functions.php';
$app = new DynamoDBFunctions();

if(isset($_POST["targetname"]))
{
    $result = $app->DeleteFriendRequest($_SESSION['username'], $_POST["targetname"]);
}

header("Location: ../display-user.php?user=" . $_POST["targetname"]);
?>