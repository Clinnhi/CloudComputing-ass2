<?php

require 'vendor/autoload.php';

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
                    'email' => $input_email
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
}
