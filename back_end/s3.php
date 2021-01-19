<?php

require 'vendor/autoload.php';
use Aws\S3\S3Client;  
use Aws\Exception\AwsException;
use Aws\Common\Exception\MultipartUploadException;
use Aws\S3\MultipartUploader;
// use Aws\DynamoDb\Marshaler;

// Instantiate a client with the credentials from the project1 profile
// $dynamoDbClient = DynamoDbClient::factory(array(
//     'profile' => 'project1',
//     'region'  => 'ap-southeast-2',
//     'version' => '2012-08-10'
// ));

// $sdk = new Aws\Sdk([
//     'profile' => 'project1',
//     'region'   => 'ap-southeast-2',
//     'version'  => 'latest',
//     'validate' => false,
//     'http'    => [
//         'verify' => 'C:\AppServ\cacert.pem'
//     ]
// ]);

$s3Client = new S3Client([
    'profile' => 'project1',
    'region'   => 'ap-southeast-2',
    'version'  => 'latest',
    'validate' => false,
    'http'    => [
        'verify' => 'C:\AppServ\cacert.pem'
    ]
]);

/** WORKING CODE FOR CREATING A BUCKET */
// $client->createBucket(array('Bucket' => 'mybucket'));

/** TO RETRIEVE THE IMAGE, JUST DO https://seanbucket1313.s3-ap-southeast-2.amazonaws.com/images/[FILENAME] */


?>

<!DOCTYPE html>
<html>
    <head><meta charset="UTF-8"></head>
    <body>
        <h1>S3 upload example</h1>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['userfile']) && $_FILES['userfile']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['userfile']['tmp_name'])) {
    // FIXME: you should add more of your own validation here, e.g. using ext/fileinfo
    
    try {
        $uploader = new MultipartUploader($s3Client, fopen($_FILES['userfile']['tmp_name'], 'rb'), [
            'bucket' => 'seanbucket1313',
            'key'    => 'images/'.$_FILES['userfile']['name']
        ]);
        // FIXME: you should not use 'name' for the upload, since that's the original filename from the user's computer - generate a random filename that you then store in your database, or similar
        // Upload data.
        $result = $uploader->upload();
        echo "Upload complete: {$result['ObjectURL']}" . PHP_EOL;
?>
        
<?php } catch(Exception $e) { ?>
        <p>Upload error :(</p>
<?php } } ?>
        <h2>Upload a file</h2>
        <form enctype="multipart/form-data" action="<?=$_SERVER['PHP_SELF']?>" method="POST">
            <input name="userfile" type="file"><input type="submit" value="Upload">
        </form>
    </body>
</html>