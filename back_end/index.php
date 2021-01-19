<?php

require 'vendor/autoload.php';

use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;

// Instantiate a client with the credentials from the project1 profile
// $dynamoDbClient = DynamoDbClient::factory(array(
//     'profile' => 'project1',
//     'region'  => 'ap-southeast-2',
//     'version' => '2012-08-10'
// ));

$sdk = new Aws\Sdk([
    // 'profile' => 'project1',
    'region'   => 'ap-southeast-2',
    'version'  => 'latest',
    // 'validate' => false,
    // 'http'    => [
    //     'verify' => 'C:\AppServ\cacert.pem'
    // ]
]);

$dynamodb = $sdk->createDynamoDb();
$marshaler = new Marshaler();


/** WORKING CODE FOR QUERYING DATA (KEY VALUES) FROM TABLE */
// $tableName = 'Users';

// // $eav = $marshaler->marshalJson('
// //     {
// //         ":g": M
// //     }
// // ');

// $params = [
//     'TableName' => $tableName,
//     'KeyConditionExpression' => '#username = :username',
//     'FilterExpression' => '#gender = :gender',
//     'ExpressionAttributeNames' => [
//         '#username' => 'username',
//         '#gender' => 'gender',
//     ],
//     'ExpressionAttributeValues'=> [
//         ':username' => [
//             'S' => 'bob',
//            ],
//          ':gender' => [
//              'S' => 'M',
//             ],
//         ],
// ];

// // echo "Querying for movies from 1985.\n";

// try {
//     $result = $dynamodb->query($params);

//     echo "Query succeeded.\n";

//     foreach ($result['Items'] as $user) {
//         echo $marshaler->unmarshalValue($user['username']) . ': ' .
//             $marshaler->unmarshalValue($user['fullname']) . "\n";
//     }

// } catch (DynamoDbException $e) {
//     echo "Unable to query:\n";
//     echo $e->getMessage() . "\n";
// }

/** END OF WORKING CODE FOR SCANNING DATA (NON-KEY VALUES) FROM TABLE */



/** WORKING CODE FOR SCANNING DATA (NON-KEY VALUES) FROM TABLE */
// $tableName = 'Users';

// // $eav = $marshaler->marshalJson('
// //     {
// //         ":g": M
// //     }
// // ');

// $params = [
//     'TableName' => $tableName,
//     'FilterExpression' => '#gender = :gender',
//     'ExpressionAttributeNames'=> [ '#gender' => 'gender' ],
//     'ExpressionAttributeValues'=> [
//          ':gender' => [
//              'S' => 'M',
//             ],
//         ],
// ];

// // echo "Querying for movies from 1985.\n";

// try {
//     $result = $dynamodb->scan($params);

//     echo "Query succeeded.\n";

//     foreach ($result['Items'] as $user) {
//         echo $marshaler->unmarshalValue($user['username']) . ': ' .
//             $marshaler->unmarshalValue($user['fullname']) . "\n";
//     }

// } catch (DynamoDbException $e) {
//     echo "Unable to query:\n";
//     echo $e->getMessage() . "\n";
// }

/** END OF WORKING CODE FOR SCANNING DATA (NON-KEY VALUES) FROM TABLE */


/** WORKING CODE FOR FETCHING DATA WITH KEY FROM TABLE */
// $tableName = 'Users';

// ob_start(); // begin collecting output

// include 'functions/test-echo.php';

// $username = ob_get_clean(); // retrieve output from myfile.php, stop buffering

// // $username = 'sean123';
// $fullname = 'Sean Tan';

// $json = json_encode([
//     'username' => $username,
//     'fullname' => $fullname
// ]);

// $key= $marshaler->marshalJson($json);

// $params = [
//     'TableName' => $tableName,
//     'Key' => $key
// ];

// try {
//     $result = $dynamodb->getItem($params);
//     $array = $result["Item"];
//     $arr=array('us'=>'United', 'ca'=>'canada');
//     // print_r($array);
//     // print_r($arr);

//     // echo $arr['ca'];
//     echo 'my username is ' . $array['username']['S'] . '<br>';
//     echo 'my username is ' . $marshaler->unmarshalValue($array['username']) . '<br>';
//     echo 'my name is ' . $array['fullname']['S'] . '<br>';
//     echo 'my password is ' . $array['password']['S'] . '<br>';

// } catch (DynamoDbException $e) {
//     echo "Unable to get item:\n";
//     echo $e->getMessage() . "\n";
// }

/** END OF WORKING CODE FOR FETCHING DATA INTO TABLE */


/** WORKING CODE FOR ADDING DATA INTO TABLE */
// $tableName = 'Users';

// $username = 'alice';
// $fullname = 'Alice';
// $password = '1234567';
// $email = 'alice@gmail.com';
// $gender = 'F';

// $json = json_encode([
//     'username' => $username,
//     'fullname' => $fullname,
//     'password' => $password,
//     'email' => $email,
//     'gender' => $gender
// ]);

// $item = $marshaler->marshalJson($json);

// $params = [
//     'TableName' => $tableName,
//     'Item' => $item
// ];


// try {
//     $result = $dynamodb->putItem($params);
//     echo "Added item: $username - $fullname\n";

// } catch (DynamoDbException $e) {
//     echo "Unable to add item:\n";
//     echo $e->getMessage() . "\n";
// }
/** END OF WORKING CODE FOR ADDING DATA INTO TABLE */



/** WORKING CODE FOR CREATING TABLES */
// $params = [
//     'TableName' => 'Users',
//     'KeySchema' => [
//         // [
//         //     'AttributeName' => 'user_id',
//         //     'KeyType' => 'HASH'  //Partition key
//         // ],
//         [
//             'AttributeName' => 'username',
//             'KeyType' => 'HASH'  //Sort key
//         ],
//         [
//             'AttributeName' => 'fullname',
//             'KeyType' => 'RANGE'  //Sort key
//         ],
        
//         // [
//         //     'AttributeName' => 'password',
//         //     'KeyType' => 'RANGE'  //Sort key
//         // ],
//     ],
//     'AttributeDefinitions' => [
//         // [
//         //     'AttributeName' => 'user_id',
//         //     'AttributeType' => 'N'
//         // ],
//         [
//             'AttributeName' => 'username',
//             'AttributeType' => 'S'
//         ],
//         [
//             'AttributeName' => 'fullname',
//             'AttributeType' => 'S'
//         ],
//         // [
//         //     'AttributeName' => 'password',
//         //     'AttributeType' => 'S'
//         // ],
//     ],
//     'ProvisionedThroughput' => [
//         'ReadCapacityUnits' => 5,
//         'WriteCapacityUnits' => 5
//     ]
// ];

// try {
//     $result = $dynamodb->createTable($params);
//     echo 'Created table.  Status: ' . 
//         $result['TableDescription']['TableStatus'] ."\n";

// } catch (DynamoDbException $e) {
//     echo "Unable to create table:\n";
//     echo $e->getMessage() . "\n";
// }
/** END OF WORKING CODE FOR CREATING TABLES */

?>

<!DOCTYPE html>
<html>

<head>
    <h1>I will connect to dynamoDB!</h1>
    <img src="https://seanbucket1313.s3-ap-southeast-2.amazonaws.com/images/03dvgl5fd7b61.png">

</head>

</html>