<?php

require 'vendor\autoload.php';

use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;

class DynamoDBFunctions
{

    function __construct()
    {
        $this->sdk = new Aws\Sdk([
            'profile' => 'project1',
            'region'   => 'ap-southeast-2',
            'version'  => 'latest',
            'validate' => false,
            'http'    => [
                'verify' => 'C:\AppServ\cacert.pem'
            ]
        ]);
        $this->dynamodb = $this->sdk->createDynamoDb();
        $this->marshaler = new Marshaler();
    }

    function __destruct()
    {
        $this->sdk = null;
        $this->dynamodb = null;
        $this->marshaler = null;
    }

    /** Login function */
    public function Login($input_username, $input_password)
    {
        $tableName = 'Users';
        $user_type = 'User';

        $json = json_encode([
            'username' => $input_username,
            'user_type' => $user_type
        ]);

        $key = $this->marshaler->marshalJson($json);

        $params = [
            'TableName' => $tableName,
            'Key' => $key
        ];

        $database_password = "";

        try {
            $result = $this->dynamodb->getItem($params);
            $array = $result["Item"];

            if (!empty($array)) {
                $database_password = $this->marshaler->unmarshalValue($array['password']);
            }

            if ($database_password == $input_password) {
                return true;
            } else {
                return false;
            }
        } catch (DynamoDbException $e) {
            return false;
        }
    }


    /** Register function */
    public function Register($input_username, $input_fullname, $input_password, $input_email)
    {
        $tableName = 'Users';
        $user_type = 'User';

        // verify if database does not already have the username
        $json = json_encode([
            'username' => $input_username,
            'user_type' => $user_type
        ]);

        $key = $this->marshaler->marshalJson($json);

        $params = [
            'TableName' => $tableName,
            'Key' => $key
        ];

        try {
            $result = $this->dynamodb->getItem($params);
            $array = $result["Item"];

            //if nothing is fetched from database means that the username is not used
            if (empty($array)) {
                // adding user info into dynamodb
                $json = json_encode([
                    'username' => $input_username,
                    'user_type' => $user_type,
                    'fullname' => $input_fullname,
                    'password' => $input_password,
                    'email' => $input_email,
                    'aboutme' => "-",
                    'crypto1' => "-",
                    'crypto2' => "-",
                    'crypto3' => "-",
                    'website1' => "-",
                    'website2' => "-",
                    'website3' => "-",
                ]);

                $item = $this->marshaler->marshalJson($json);

                $params = [
                    'TableName' => $tableName,
                    'Item' => $item
                ];

                try {
                    $result = $this->dynamodb->putItem($params);
                    return true;
                } catch (DynamoDbException $e) {
                    return false;
                }
            } else {
                return false;
            }
        } catch (DynamoDbException $e) {
            return false;
        }
    }

    /** UpdatePersonalInfo function */
    public function UpdatePersonalInfo($username, $fullname, $password, $email, $aboutme, $crypto1, $crypto2, $crypto3, $website1, $website2, $website3)
    {
        $tableName = 'Users';
        $user_type = 'User';

        // verify if database does not already have the username
        $json = json_encode([
            'username' => $username,
            'user_type' => $user_type
        ]);

        $key = $this->marshaler->marshalJson($json);

        $params = [
            'TableName' => $tableName,
            'Key' => $key
        ];

        try {
            $result = $this->dynamodb->getItem($params);
            $array = $result["Item"];

            //if something is fetched from database means that the username is valid
            if (!empty($array)) {
                // adding user info into dynamodb
                $json = json_encode([
                    'username' => $username,
                    'user_type' => $user_type,
                    'fullname' => $fullname,
                    'password' => $password,
                    'email' => $email,
                    'aboutme' => $aboutme,
                    'crypto1' => $crypto1,
                    'crypto2' => $crypto2,
                    'crypto3' => $crypto3,
                    'website1' => $website1,
                    'website2' => $website2,
                    'website3' => $website3,
                ]);

                $item = $this->marshaler->marshalJson($json);

                $params = [
                    'TableName' => $tableName,
                    'Item' => $item
                ];

                try {
                    $result = $this->dynamodb->putItem($params);
                    return true;
                } catch (DynamoDbException $e) {
                    return false;
                }
            } else {
                return false;
            }
        } catch (DynamoDbException $e) {
            return false;
        }
    }

    /** UserDetails function - Returns info of a user as an array */
    public function UserDetails($username)
    {
        $tableName = 'Users';

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

        try {
            $result = $this->dynamodb->query($params);

            return $result['Items'];

            // foreach ($result['Items'] as $user) {
            //     echo $this->marshaler->unmarshalValue($user['username']) . ': ' .
            //         $this->marshaler->unmarshalValue($user['fullname']) . "\n";
            // }

        } catch (DynamoDbException $e) {
            return false;
        }
    }

    /** Send friend request function */
    public function SendFriendRequest($username, $targetname)
    {
        $tableName = 'FriendRequest';

        $json = json_encode([
            'username' => $username,
            'targetname' => $targetname
        ]);

        $item = $this->marshaler->marshalJson($json);

        $params = [
            'TableName' => $tableName,
            'Item' => $item
        ];

        try {
            $result = $this->dynamodb->putItem($params);
            return true;
        } catch (DynamoDbException $e) {
            return false;
        }
    }

    /** Accept friend request function */
    public function AcceptFriendRequest($username, $targetname, $accept)
    {
        // 1. delete the friend request
        $tableName = 'FriendRequest';

        $json = json_encode([
            'username' => $username,
            'targetname' => $targetname
        ]);

        $key = $this->marshaler->marshalJson($json);

        $params = [
            'TableName' => $tableName,
            'Key' => $key
        ];

        try {
            $result = $this->dynamodb->deleteItem($params);
        } catch (DynamoDbException $e) {
            return false;
        }

        // 2. add the friend pair into Friend table if accept is true
        if ($accept) {
            $tableName = 'FriendList';

            $json1 = json_encode([
                'username' => $username,
                'friendname' => $targetname
            ]);

            $json2 = json_encode([
                'username' => $targetname,
                'friendname' => $username
            ]);

            $item1 = $this->marshaler->marshalJson($json1);
            $item2 = $this->marshaler->marshalJson($json2);

            $params1 = [
                'TableName' => $tableName,
                'Item' => $item1
            ];
            $params2 = [
                'TableName' => $tableName,
                'Item' => $item2
            ];

            try {
                $result1 = $this->dynamodb->putItem($params1);
                $result2 = $this->dynamodb->putItem($params2);
            } catch (DynamoDbException $e) {
                return false;
            }
        }

        return true;
    }

    /** isFriend function - Check if you are friends with target user */
    public function isFriend($username, $targetname)
    {
        // 1. delete the friend request
        $tableName = 'FriendList';

        $json = json_encode([
            'username' => $username,
            'friendname' => $targetname
        ]);

        $key = $this->marshaler->marshalJson($json);

        $params = [
            'TableName' => $tableName,
            'Key' => $key
        ];

        try {
            $result = $this->dynamodb->getItem($params);
            $array = $result["Item"];

            if (!empty($array)) {
                return true;
            } else {
                return false;
            }
        } catch (DynamoDbException $e) {
            return false;
        }

        return true;
    }

    /** FriendList function - Returns an array of a user's friends */
    public function FriendList($username)
    {
        $tableName = 'FriendList';

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

        try {
            $result = $this->dynamodb->query($params);

            return $result['Items'];

            // foreach ($result['Items'] as $user) {
            //     echo $this->marshaler->unmarshalValue($user['username']) . ': ' .
            //         $this->marshaler->unmarshalValue($user['fullname']) . "\n";
            // }

        } catch (DynamoDbException $e) {
            return false;
        }
    }

    
}
