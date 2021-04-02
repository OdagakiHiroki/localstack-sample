<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="/index.html">戻る</a>
</body>
</html>

<?php
require '../../vendor/autoload.php';

use Aws\S3\S3Client;

$bucket = 'sample-bucket';
$keyname = 'upload.txt';

$s3 = new S3Client([
    'version' => 'latest',
    'region' => 'ap-northeast-1',
    'endpoint' => 'http://localstack:4566',
    'credentials' => [
        'key' => '',
        'secret' => '',
    ],
    'use_path_style_endpoint' => true,
]);

$cmd = $s3->getCommand('GetObject', [
    'Bucket' => $bucket,
    'Key' => $keyname,
]);

$request = $s3->createPresignedRequest($cmd, '+2minutes');

$presignedUrl = $request->getUri();

echo $presignedUrl;

?>
