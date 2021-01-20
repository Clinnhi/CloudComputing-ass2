<?php

// Load the function class
require 'functions/dynamodb_functions.php';
$app = new DynamoDBFunctions();

// echo $app->Login('alice', '1234567');

// echo $app->SendFriendRequest('alice', 'bob');

// echo $app->AcceptFriendRequest('alice', 'john', true);

// echo $app->isFriend('alice', 'john');

 

$friends = $app->FriendList('alice');

foreach ($friends as $friend) {
    echo $friend['friendname']['S'] . '<br>';
}
?>