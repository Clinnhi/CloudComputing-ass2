<?php
session_start();
require '../functions/dynamodb_functions.php';
require '../functions/s3_functions.php';
$app = new DynamoDBFunctions();
$s3 = new S3Functions();


if(isset($_POST['username']))
{
    $result = $app->DeletePost($_POST['username'], $_POST['timestamp']);
    $result1 = $s3->deletePostPicture($_POST['username'], $_POST['timestamp']);
}

header("Location: ../display-user.php?user=" . $_POST["username"]);
?>