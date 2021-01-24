<?php 

require 'functions/dynamodb_functions.php';
$app = new DynamoDBFunctions();

$data = $app->SearchUser("bob");

echo json_encode($data);

?>