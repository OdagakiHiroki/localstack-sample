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
$keyname = 'sample.txt';

$s3 = new S3Client([
    'version' => 'latest',
    'region'  => 'ap-northeast-1',
    'endpoint' => 'http://localstack:4566',
    // NOTE: use_path_style_endpointが使えない場合、host解決をした上でエンドポイントをpath styleで指定することでlocalstackを動かすことができる
    // 'endpoint' => 'http://localstack:4566/' . $bucket . '/' . $keyname,
    'credentials' => [
        'key' => '',
        'secret' => '',
    ],
    'use_path_style_endpoint' => true,
]);

try {
    // Get the object.
    $result = $s3->getObject([
        'Bucket' => $bucket,
        'Key'    => $keyname
    ]);

    // Display the object in the browser.
    // header("Content-Type: {$result['ContentType']}");
    echo $result['Body'];
} catch (S3Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
?>
