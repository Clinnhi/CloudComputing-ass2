<?php

require 'vendor/autoload.php';

use Aws\CloudFront\CloudFrontClient;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Aws\Common\Exception\MultipartUploadException;
use Aws\S3\MultipartUploader;

class S3Functions
{

    function __construct()
    {
        $this->s3Client = new S3Client([
            'region'   => 'ap-southeast-2',
            'version'  => 'latest'
        ]);

        // cloudfront
        $this->cloudFront = new CloudFrontClient([
            'region'   => 'ap-southeast-2',
            'version'  => 'latest',
        ]);

        // S3 BUCKET URLS
        $this->bucketname = 'imagesfblite2';
        $this->profileUrl = 'https://imagesfblite2.s3-ap-southeast-2.amazonaws.com/profile/';
        $this->postUrl = 'https://imagesfblite2.s3-ap-southeast-2.amazonaws.com/post/';

        // CloudFront URLS
        $this->cloudFrontUrl = 'https://d32i8jhnn3o5ck.cloudfront.net/';
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

    /** Function for getting the link of a post picture*/
    public function getPostMediaLink($imageURL)
    {
        return $this->cloudFrontUrl . $imageURL;
    }

    /** Function for updating a user's profile picture */
    public function updateProfilePicture($username, $file_upload) {
        try{
            // delete old profile image
            $result = $this->s3Client->deleteObject([
                'Bucket' => $this->bucketname,
                'Key'    => 'profile/' . $username
            ]);

            // upload new profile image
            $uploader = new MultipartUploader($this->s3Client, fopen($file_upload, 'rb'), [
                'bucket' => $this->bucketname,
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
                'Bucket' => $this->bucketname,
                'Key'    => 'post/' . $username . $timestamp
            ]);

            // uploading image
            $uploader = new MultipartUploader($this->s3Client, fopen($file_upload, 'rb'), [
                'bucket' => $this->bucketname,
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
                'Bucket' => $this->bucketname,
                'Key'    => 'post/' . $username . $timestamp
            ]);

            return $result;
        } catch(Exception $e) {
            return $e;
        }
    }

    // /** Test function for using cloud front */
    // public function testcloudfront() {
    //     $object = 'cat.mp4';
    //     $expiry = new DateTime('+10 minutes');
    //     $url = $this->cloudFront->getSignedUrl([
    //         'url' => $this->cloudFrontUrl . "/" . $object,
    //         'expires' => $expiry->getTimestamp()
    //     ]);

    //     return $url;
    // }

}
