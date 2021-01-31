<?php

set_time_limit(0);
 
require 'vendor/autoload.php';
  
use Aws\S3\S3Client;
use Aws\TranscribeService\TranscribeServiceClient;
 
if ( isset($_POST['submit']) ) {
 
    $arr_mime_types = ['audio/wav', 'audio/mpeg', 'video/mp4', 'audio/x-flac'];
    if ( !in_array($_FILES['audio']['type'], $arr_mime_types) ) {
        die('File type is not allowed');
    }
 
    $region = 'us-east-1';
    $access_key = 'AKIAI2KGGIOUITKHK7CA';
    $secret_access_key = '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';
 
    // Instantiate an Amazon S3 client.
    $s3 = new S3Client([
        'version' => 'latest',
        'region'  => $region,
        'credentials' => [
            'key'    => $access_key,
            'secret' => $secret_access_key
        ]
    ]);
 
    $bucketName = 'cloud-computing-speechaws';
    $key = basename($_FILES['audio']['name']);
 
    // upload file on S3 Bucket
    try {
        $result = $s3->putObject([
            'Bucket' => $bucketName,
            'Key'    => $key,
            'Body'   => fopen($_FILES['audio']['tmp_name'], 'r'),
            'ACL'    => 'public-read',
        ]);
        $audio_url = $result->get('ObjectURL');
 
        // Create Amazon Transcribe Client
        $awsTranscribeClient = new TranscribeServiceClient([
            'region' => $region,
            'version' => 'latest',
            'credentials' => [
                'key'    => $access_key,
                'secret' => $secret_access_key
            ]
        ]);
 
        // Start a Transcription Job
        $job_id = uniqid();
        $transcriptionResult = $awsTranscribeClient->startTranscriptionJob([
                'LanguageCode' => 'en-US',
                'Media' => [
                    'MediaFileUri' => $audio_url,
                ],
                'TranscriptionJobName' => $job_id,
        ]);
 
        $status = array();
        while(true) {
            $status = $awsTranscribeClient->getTranscriptionJob([
                'TranscriptionJobName' => $job_id
            ]);
 
            if ($status->get('TranscriptionJob')['TranscriptionJobStatus'] == 'COMPLETED') {
                break;
            }
 
            sleep(5);
        }
 
        $url = $status->get('TranscriptionJob')['Transcript']['TranscriptFileUri'];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $data = curl_exec($curl);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            echo $error_msg;
        }
        curl_close($curl);
        $arr_data = json_decode($data);
 
        // download a file
        $file = $job_id.".txt";
        $txt = fopen($file, "w") or die("Unable to open file!");
        fwrite($txt, $arr_data->results->transcripts[0]->transcript);
        readfile($file);
        // document.getElementById('textArea').value = echo htmlspecialchars(readfile($file));

        fclose($txt);





        
        // readfile($file);
        // exit();
    }  catch (Exception $e) {
        echo $e->getMessage();
    }
}
?>