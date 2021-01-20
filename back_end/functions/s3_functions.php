<?php

require 'vendor\autoload.php';

use Aws\S3\S3Client;  
use Aws\Exception\AwsException;
use Aws\Common\Exception\MultipartUploadException;
use Aws\S3\MultipartUploader;

class S3Functions
{

    function __construct()
    {
        $this->s3Client = new S3Client([
            'profile' => 'project1',
            'region'   => 'ap-southeast-2',
            'version'  => 'latest',
            'validate' => false,
            'http'    => [
                'verify' => 'C:\AppServ\cacert.pem'
            ]
        ]);
    }

    function __destruct()
    {
        $this->s3Client = null;
    }

   
}
