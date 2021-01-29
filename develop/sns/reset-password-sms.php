<?php

// resetting password and fetching phone number and the new temporary password
$phone = "";
$temp_password = "";
$username = "";
$error = false;

if (!empty($_POST['username'])) {
    require '../functions/dynamodb_functions.php';
    $app = new DynamoDBFunctions();

    try {
        $username = $_POST['username'];
        $user = $app->UserDetails($username);
        $phone = $user[0]['phone']['S'];
        $temp_password = $app->ResetPassword($username);
    } catch (Exception $e) {
        $error = true;
    }
} else {
    header("Location: ../loginpage.php");
}

if (!$error) {
    // preparing sms
    require './vendor/autoload.php';

    $params = array(
        'profile' => 'project1',
        'region'   => 'ap-southeast-2',
        'version'  => 'latest',
        'validate' => false,
        'http'    => [
            'verify' => 'C:\AppServ\cacert.pem'
        ]
    );
    $sns = new \Aws\Sns\SnsClient($params);

    $message = "Dear " . $username . ", your temporary password is " . $temp_password;

    $args = array(
        "MessageAttributes" => [
            'AWS.SNS.SMS.SMSType' => [
                'DataType' => 'String',
                'StringValue' => 'Transactional'
            ]
        ],
        "Message" => $message,
        // -- +{CountryCode}{PhoneNumber} --
        "PhoneNumber" => $phone   // Provide phone number with country code
    );

    try {
        $result = $sns->publish($args);
    } catch (Exception $e) {
    }
}

// echo '<script>alert("Password has been reset successfully!")</script>';

echo '<script>if (window.confirm("Password has been reset successfully! Click OK to go back to Login page.")){window.location.href=\'../loginpage.php\';};</script>';


// var_dump($result); // You can check the response