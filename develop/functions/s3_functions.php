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

        // S3 BUCKET URL
        $this->url = 'https://imagesfblite.s3-ap-southeast-2.amazonaws.com/profile/';
    }

    function __destruct()
    {
        $this->s3Client = null;
    }

    /** Function for getting the link of a user's profile picture */
    public function getProfilePictureLink($username)
    {
        return $this->url . $username;
    }

    /** Function for updating a user's profile picture */
    public function updateProfilePicture($username, $file_upload) {
        try{
            $uploader = new MultipartUploader($this->s3Client, fopen($file_upload, 'rb'), [
                'bucket' => 'imagesfblite',
                'key'    => 'profile/' . $username
            ]);
            $result = $uploader->upload();
        } catch(Exception $e) {

        }
        
    }
}
