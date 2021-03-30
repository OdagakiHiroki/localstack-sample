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
require '../../../vendor/autoload.php';

use Aws\Common\Exception\MultipartUploadException;
use Aws\S3\MultipartUploader;
use Aws\S3\S3Client;

$bucket = 'sample-bucket';
$keyname = 'multi-part-upload.txt';

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

$uploader = new MultipartUploader($s3, './multi-part-upload.txt', [
    'Bucket' => $bucket,
    'key' => $keyname
]);

try {
    $result = $uploader->upload();
    echo "upload complete {$result['ObjectURL']}";
} catch (MultipartUploadException $e) {
    echo $e->getMessage();
}

?>
