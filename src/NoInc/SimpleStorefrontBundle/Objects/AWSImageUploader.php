<?php

namespace NoInc\SimpleStorefrontBundle\Objects;

use Aws\S3\S3Client;
use Aws\Credentials\CredentialProvider;

class AWSImageUploader
{
    private $client;

    public function __construct($awsConfigPath)
    {
        $provider = CredentialProvider::ini('default', $awsConfigPath);
        $provider = CredentialProvider::memoize($provider);
        $this->client = new S3Client([
            'region'      => 'us-east-1',
            'version'     => 'latest',
            'credentials' => $provider
        ]);
    }

    public function upload($image, $imageName)
    {
        $result = $this->client->putObject(array(
            'Bucket'    => 'simplestorefront',
            'Key'       => $imageName,
            'Body'      => $image,
            'ACL'       => 'public-read'
        ));

        if (isset($result['ObjectURL'])) {
            return $result['ObjectURL'];
        }
        return false;
    }
}
