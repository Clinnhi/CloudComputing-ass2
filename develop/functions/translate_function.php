<?php

require 'vendor/autoload.php';

use Aws\Translate\TranslateClient; 
use Aws\Exception\AwsException;
use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;

class AwsTranslateFunctions
{
    function __construct()
    {
        $this->translateClient = new Aws\Translate\TranslateClient([
            'region'   => 'ap-southeast-2',
            'version'  => 'latest'
        ]);

        $this->marshaler = new Marshaler();
    }

    function __destruct()
    {
        $this->translateClient = null;
        $this->marshaler = null;
    }

    public function translateText($text, $text_language) {
        try {
            $result = $this->translateClient->translateText([
                'SourceLanguageCode' => $text_language,
                'TargetLanguageCode' => 'en',
                'Text' => $text,
            ]);
            // var_dump($result);
            return $result['TranslatedText'];
        } catch (AwsException $e) {
            return false;
        }
    }
}