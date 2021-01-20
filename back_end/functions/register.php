<?php

require '../vendor/autoload.php';

use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;

// data from POST method 
// $input_username = trim($_POST['username']);
// $input_fullname = trim($_POST['fullname']);
// $input_email = trim($_POST['email']);
// $input_password = trim($_POST['password']);


// placeholders for testing
$input_username = 'bob2';
$input_fullname = 'Bob1';
$input_password = '1231231';
$input_email = 'bob22221@gmail.com';

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

// verify if database does not already have the username
$json = json_encode([
    'username' => $input_username,
    'user_type' => $user_type
]);

$key = $marshaler->marshalJson($json);

$params = [
    'TableName' => $tableName,
    'Key' => $key
];

try {
    $result = $dynamodb->getItem($params);
    $array = $result["Item"];

    //if nothing is fetched from database means that the username is not used
    if (empty($array)) {
        // adding user info into dynamodb
        $json = json_encode([
            'username' => $input_username,
            'user_type' => $user_type,
            'fullname' => $input_fullname,
            'password' => $input_password,
            'email' => $input_email
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
    } else {
        echo 'username is taken';
        echo false;
    }
} catch (DynamoDbException $e) {
    echo false;
}

?>