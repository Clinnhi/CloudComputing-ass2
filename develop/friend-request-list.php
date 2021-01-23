<?php 
session_start();
require 'functions/dynamodb_functions.php';
$app = new DynamoDBFunctions();

$result = $app->FriendRequestList($_SESSION['username']);

var_dump($result);

echo '<br>';

foreach($result as $user) {
    // var_dump($user);
    $username = $user['username']['S'];
    echo $username;
}



?>