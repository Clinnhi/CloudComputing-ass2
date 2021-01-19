<?php

require '../vendor/autoload.php';

use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;

// data from POST method 
// $username = trim($_POST['username']);
// $fullname = trim($_POST['fullname']);
// $email = trim($_POST['email']);
// $password = trim($_POST['password']);


// placeholders for testing
$username = 'bob1';
$fullname = 'Bob1';
$password = '1231231';
$email = 'bob1@gmail.com';

// initializing aws sdk for dynamodb
$sdk = new Aws\Sdk([
    'profile' => 'project1',
    'region'   => 'ap-southeast-2',
    'version'  => 'latest',
    'validate' => false,
    'http'    => [
        'verify' => 'C:\AppServ\cacert.pem'
    ]
]);

$dynamodb = $sdk->createDynamoDb();
$marshaler = new Marshaler();

$tableName = 'Users';
$user_type = 'User';



$json = json_encode([
    'username' => $username,
    'user_type' => $user_type,
    'fullname' => $fullname,
    'password' => $password,
    'email' => $email
]);

$item = $marshaler->marshalJson($json);

$params = [
    'TableName' => $tableName,
    'Item' => $item
];


try {
    $result = $dynamodb->putItem($params);
    echo true;

} catch (DynamoDbException $e) {
    echo false;
}

?>