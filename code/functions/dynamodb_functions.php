<?php

require 'vendor/autoload.php';

use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;

class DynamoDBFunctions
{

    function __construct()
    {
        $this->sdk = new Aws\Sdk([
            'region'   => 'ap-southeast-2',
            'version'  => 'latest'
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
    public function Register($input_username, $input_fullname, $input_password, $input_email, $input_phone)
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
                    'phone' => $input_phone
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
    public function UpdatePersonalInfo($username, $fullname, $password, $email, $aboutme, $crypto1, $crypto2, $crypto3, $website1, $website2, $website3, $phone)
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
                    'phone' => $phone
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

    /** Reset password function */
    public function ResetPassword($username)
    {
        $tableName = 'Users';
        $user_type = 'User';

        $user = $this->UserDetails($username);
        $user = $user[0];
        $fullname = $user['fullname']['S'];
        $email = $user['email']['S'];
        $aboutme = $user['aboutme']['S'];
        $crypto1 = $user['crypto1']['S'];
        $crypto2 = $user['crypto2']['S'];
        $crypto3 = $user['crypto3']['S'];
        $website1 = $user['website1']['S'];
        $website2 = $user['website2']['S'];
        $website3 = $user['website3']['S'];
        $phone = $user['phone']['S'];

        // creating random password
        $random_password = strval(rand(1000, 10000));

        $json = json_encode([
            'username' => $username,
            'user_type' => $user_type,
            'fullname' => $fullname,
            'password' => $random_password,
            'email' => $email,
            'aboutme' => $aboutme,
            'crypto1' => $crypto1,
            'crypto2' => $crypto2,
            'crypto3' => $crypto3,
            'website1' => $website1,
            'website2' => $website2,
            'website3' => $website3,
            'phone' => $phone
        ]);

        $item = $this->marshaler->marshalJson($json);

        $params = [
            'TableName' => 'Users',
            'Item' => $item
        ];

        try {
            $result = $this->dynamodb->putItem($params);
            return $random_password;
        } catch (DynamoDbException $e) {
            return $e;
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
            'ExpressionAttributeValues' => [
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

    /** Delete friend request function */
    public function DeleteFriendRequest($username, $targetname)
    {
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
    }

    /** Delete friend function */
    public function DeleteFriend($username, $targetname)
    {
        $tableName = 'FriendList';

        $json = json_encode([
            'username' => $username,
            'friendname' => $targetname
        ]);

        $json1 = json_encode([
            'username' => $targetname,
            'friendname' => $username
        ]);

        $key = $this->marshaler->marshalJson($json);
        $key1 = $this->marshaler->marshalJson($json1);

        $params = [
            'TableName' => $tableName,
            'Key' => $key
        ];

        $params1 = [
            'TableName' => $tableName,
            'Key' => $key1
        ];

        try {
            $result = $this->dynamodb->deleteItem($params);
            $result1 = $this->dynamodb->deleteItem($params1);
        } catch (DynamoDbException $e) {
            return false;
        }
    }

    /** friend request sent function - checks if user already sent a friend request to target */
    public function FriendRequestSent($username, $targetname)
    {
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

    /** Accept friend request function */
    public function AcceptFriendRequest($username, $targetname, $accept)
    {
        // 1. delete the friend request
        $tableName = 'FriendRequest';

        $json = json_encode([
            'username' => $targetname,
            'targetname' => $username
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
            'ExpressionAttributeValues' => [
                ':username' => [
                    'S' => $username,
                ],
            ],
        ];

        try {
            $result = $this->dynamodb->query($params);

            return $result['Items'];
        } catch (DynamoDbException $e) {
            return false;
        }
    }

    /** FriendRequestList function - Returns an array of a user's friends */
    public function FriendRequestList($username)
    {
        $tableName = 'FriendRequest';

        $params = [
            'TableName' => $tableName,
            'FilterExpression' => '#targetname = :targetname',
            'ExpressionAttributeNames' => ['#targetname' => 'targetname'],
            'ExpressionAttributeValues' => [
                ':targetname' => [
                    'S' => $username,
                ],
            ],
        ];

        try {
            $result = $this->dynamodb->scan($params);

            return $result['Items'];

            // foreach ($result['Items'] as $user) {
            //     echo $this->marshaler->unmarshalValue($user['username']) . ': ' .
            //         $this->marshaler->unmarshalValue($user['fullname']) . "\n";
            // }

        } catch (DynamoDbException $e) {
            return false;
        }
    }

    /** SearchUser function - returns search result of user list */
    public function SearchUser($input_name)
    {
        $tableName = 'Users';

        $params = [
            'TableName' => $tableName
        ];

        try {
            $users = $this->dynamodb->scan($params);

            $user_array = array();
            $log = "";

            foreach ($users['Items'] as $user) {
                if ($input_name) {

                    $string = $user['fullname']['S'];

                    $result = stripos($string, $input_name);
                    // $log .= '(' . $user['fullname']['S'] . 'vs' . $input_name . ')';
                    // $log .= $result;
                    if (strlen($result) > 0) {
                        $log .= "1";
                        array_push($user_array, $user);
                    } else {
                        $log .= "2";
                    }
                } else {
                    $log .= "3";
                    array_push($user_array, $user);
                }
            }

            // return $log;
            return $user_array;
        } catch (DynamoDbException $e) {
            return false;
        }
    }

    /** Create post function */
    public function CreatePost($username, $content, $imageURL, $language)
    {
        $tableName = 'Posts';

        //record timestamp
        $timestamp = time();

        try {
            // adding user info into dynamodb
            $json = json_encode([
                'username' => $username,
                'timestamp' => $timestamp,
                'content' => $content,
                'imageURL' => $imageURL,
                'language' => $language
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
        } catch (DynamoDbException $e) {
            return false;
        }
    }

    /** Delete post function */
    public function DeletePost($username, $timestamp)
    {
        $tableName = 'Posts';

        $json = json_encode([
            'username' => $username,
            'timestamp' => intval($timestamp)
        ]);

        $key = $this->marshaler->marshalJson($json);

        $params = [
            'TableName' => $tableName,
            'Key' => $key
        ];

        try {
            $result = $this->dynamodb->deleteItem($params);
            return $result;
        } catch (DynamoDbException $e) {
            return $e;
        }
    }

    /** Fetch user post function - fetch all posts from the target user */
    public function FetchUserPosts($targetname)
    {
        $tableName = 'Posts';

        $params = [
            'TableName' => $tableName
        ];

        try {
            $posts = $this->dynamodb->scan($params);

            $filtered_post = array(); // filtered to only fetch friend's posts
            $log = "";

            foreach ($posts['Items'] as $post) {
                $log .= 'iterated ';
                if ($post['username']['S'] == $targetname) {
                    array_unshift($filtered_post, $post);
                }
            }

            // return $log;
            return $filtered_post;
        } catch (DynamoDbException $e) {
            return false;
        }
    }

    /** Fetch all friend's post function - fetch all posts of users who are friends with the target user */
    public function FetchAllFriendsPosts($username)
    {
        $tableName = 'Posts';

        $params = [
            'TableName' => $tableName
        ];

        try {
            $posts = $this->dynamodb->scan($params);

            $filtered_post = array(); // filtered to only fetch friend's posts
            $log = "";

            foreach ($posts['Items'] as $post) {
                $log .= 'iterated ';
                if ($this->isFriend($username, $post['username']['S'])) {
                    array_unshift($filtered_post, $post);
                }
            }

            // return $log;
            return $filtered_post;
        } catch (DynamoDbException $e) {
            return false;
        }
    }

    /** Fetch messages function - fetch all messages sent between two friends */
    public function FetchMessages($username, $friendname)
    {
        $tableName = 'Messages';

        $friendpair = "";

        // find friendpair
        if ($username < $friendname) {
            $friendpair = $username . "-" . $friendname;
        } else {
            $friendpair = $friendname . "-" . $username;
        }

        $params = [
            'TableName' => $tableName,
            'KeyConditionExpression' => '#friendpair = :friendpair',
            'ExpressionAttributeNames' => [
                '#friendpair' => 'friendpair',
            ],
            'ExpressionAttributeValues' => [
                ':friendpair' => [
                    'S' => $friendpair,
                ],
            ],
        ];

        try {
            $result = $this->dynamodb->query($params);

            return $result['Items'];
        } catch (DynamoDbException $e) {
            return false;
        }
    }

    /** Send message function - Sends a message to another friend */
    public function SendMessage($username, $friendname, $content)
    {
        $tableName = 'Messages';

        $friendpair = "";

        // find friendpair
        if ($username < $friendname) {
            $friendpair = $username . "-" . $friendname;
        } else {
            $friendpair = $friendname . "-" . $username;
        }

        //record timestamp
        $timestamp = time();

        try {
            // adding user info into dynamodb
            $json = json_encode([
                'friendpair' => $friendpair,
                'timestamp' => $timestamp,
                'author' => $username,
                'content' => $content
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
        } catch (DynamoDbException $e) {
            return false;
        }
    }
}
