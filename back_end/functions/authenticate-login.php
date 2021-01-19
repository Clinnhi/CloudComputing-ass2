<?php

require 'vendor/autoload.php';

use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;

// data from POST method 
$username = trim($_POST['username']);
$password = trim($_POST['password']);

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

// query the user entity from database
$params = [
    'TableName' => $tableName,
    'KeyConditionExpression' => '#username = :username',
    'ExpressionAttributeNames' => [
        '#username' => 'username',
    ],
    'ExpressionAttributeValues'=> [
        ':username' => [
            'S' => $username,
           ],
        ],
];

// echo "Querying for movies from 1985.\n";

try {
    $result = $dynamodb->query($params);

    echo "Query succeeded.\n";

    foreach ($result['Items'] as $user) {
        echo $marshaler->unmarshalValue($user['username']) . ': ' .
            $marshaler->unmarshalValue($user['fullname']) . "\n";
    }

} catch (DynamoDbException $e) {
    echo "Unable to query:\n";
    echo $e->getMessage() . "\n";
}

?>