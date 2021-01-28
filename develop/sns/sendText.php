<!-- key ID -->
<!-- AKIARQCLRSM2W6JGYN3C -->

<!-- SECRET ACCESS KEY -->
<!-- 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 -->

<?php
require './vendor/autoload.php';

$mobile_number = $_POST['mobile_number'];
$message = $_POST['message'];
$name = $_POST['name'];



$params = array(
    // 'credentials' => array(
    //     'key' => 'AKIARQCLRSM2W6JGYN3C',
    //     'secret' => 'xNnE2uEQFCwORTOXEc5SDlVEYa956K48CYAJHGNl',
    // ),
    // 'region' => 'us-east-1', // < your aws from SNS Topic region
    // 'version' => 'latest'
    'profile' => 'project1',
    'region'   => 'ap-southeast-2',
    'version'  => 'latest',
    'validate' => false,
    'http'    => [
        'verify' => 'C:\AppServ\cacert.pem'
    ]
);
$sns = new \Aws\Sns\SnsClient($params);

$args = array(
    "MessageAttributes" => [
        // 'AWS.SNS.SMS.SenderID' => [
        //     'DataType' => 'String',
        //     'StringValue' => ''
        // ],
        'AWS.SNS.SMS.SMSType' => [
            'DataType' => 'String',
            'StringValue' => 'Transactional'
        ]
    ],
    "Message" => $message . ' sent by ' . $name . ' From RMIT Cloud Computing.',
    // -- +{CountryCode}{PhoneNumber} --
    "PhoneNumber" => $mobile_number   // Provide phone number with country code
);

$result = $sns->publish($args);
echo '<script>alert("Message successfuly sent, redirecting to home page...")</script>'; 


// var_dump($result); // You can check the response