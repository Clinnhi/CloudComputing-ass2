<?php 

// require_once('DB.php');


// $name = $_POST['name'];
// $con = new DB();
// $data = $con->searchData($name);

// echo json_encode($data);

require 'functions/dynamodb_functions.php';
$app = new DynamoDBFunctions();

$data = $app->SearchUser("bob");

// echo $_POST['name'];
// var_dump($result);
echo json_encode($data);

?>