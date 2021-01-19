<?php

require '../vendor/autoload.php';

use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;

// data from POST method 
// $username = trim($_POST['username']);
// $password = trim($_POST['password']);

// placeholders for testing
$input_username = 'alice1';
$input_password = '1234567';

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

// $fullname = 'Sean Tan';

$json = json_encode([
    'username' => $input_username,
    'user_type' => $user_type
]);

$key= $marshaler->marshalJson($json);

$params = [
    'TableName' => $tableName,
    'Key' => $key
];

$database_password = "";

try {
    $result = $dynamodb->getItem($params);
    $array = $result["Item"];

    if (!empty($array)) {
        $database_password = $marshaler->unmarshalValue($array['password']);
    }

    if ($database_password == $input_password) {
        echo true;
    }
    else {
        echo false;
    }
} catch (DynamoDbException $e) {
    echo false;
}

?>