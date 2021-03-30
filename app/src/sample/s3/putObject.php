<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="/index.html">トップへ戻る</a>
</body>
</html>

<?php
require '../../vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

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

try {
    $result = $s3->putObject([
        'Bucket' => $bucket,
        'Key' => $keyname,
        'Body' => 'this is upload text.',
        'ACL' => 'public-read',
    ]);

    echo $result['ObjectURL'];
} catch (S3Exception $e) {
    echo $e->getMessage();
}
?>
