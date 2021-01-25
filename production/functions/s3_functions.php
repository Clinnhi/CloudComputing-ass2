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
            // 'profile' => 'project1',
            'region'   => 'ap-southeast-2',
            'version'  => 'latest'
            // 'validate' => false,
            // 'http'    => [
            //     'verify' => 'C:\AppServ\cacert.pem'
            // ]
        ]);

        // S3 BUCKET URLS
        $this->profileUrl = 'https://imagesfblite.s3-ap-southeast-2.amazonaws.com/profile/';
        $this->postUrl = 'https://imagesfblite.s3-ap-southeast-2.amazonaws.com/post/';
    }

    function __destruct()
    {
        $this->s3Client = null;
    }

    /** Function for getting the link of a user's profile picture */
    public function getProfilePictureLink($username)
    {
        return $this->profileUrl . $username;
    }

    /** Function for getting the link of a post picture */
    public function getPostPictureLink($imageURL)
    {
        return $this->postUrl . $imageURL;
    }

    /** Function for updating a user's profile picture */
    public function updateProfilePicture($username, $file_upload) {
        try{
            // delete old profile image
            $result = $this->s3Client->deleteObject([
                'Bucket' => 'imagesfblite',
                'Key'    => 'profile/' . $username
            ]);

            // upload new profile image
            $uploader = new MultipartUploader($this->s3Client, fopen($file_upload, 'rb'), [
                'bucket' => 'imagesfblite',
                'key'    => 'profile/' . $username
            ]);
            $result1 = $uploader->upload();
        } catch(Exception $e) {

        }
    }

    /** Function for uploading a user's post's picture */
    public function uploadPostPicture($username, $file_upload, $timestamp) {
        try{
            // try deleting an existing file with same name just to prevent errors
            $result = $this->s3Client->deleteObject([
                'Bucket' => 'imagesfblite',
                'Key'    => 'post/' . $username . $timestamp
            ]);

            // uploading image
            $uploader = new MultipartUploader($this->s3Client, fopen($file_upload, 'rb'), [
                'bucket' => 'imagesfblite',
                'key'    => 'post/' . $username . $timestamp
            ]);
            $result1 = $uploader->upload();
        } catch(Exception $e) {

        }
    }

    /** Function for deleting a user's post's picture */
    public function deletePostPicture($username, $timestamp) {
        try{
            // try deleting an existing file with same name just to prevent errors
            $result = $this->s3Client->deleteObject([
                'Bucket' => 'imagesfblite',
                'Key'    => 'post/' . $username . $timestamp
            ]);

            return $result;
        } catch(Exception $e) {
            return $e;
        }
    }

}
