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

use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;

$bucket = 'sample-bucket';
$keyname = 'low-level-multi-part-upload.txt';
$filename = './multi-part-upload.txt';

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

$createResult = $s3->createMultipartUpload([
    'Bucket' => $bucket,
    'Key' => $keyname,
    'Metadata' => [
        'param1' => 'value1',
        'param2' => 'value2',
        'param3' => 'value3',
    ]
]);

$uploadId = $createResult['UploadId'];

try {
    $file = fopen($filename, 'r');
    $partNumber = 1;
    while (!feof($file)) {
        $uploadResult = $s3->uploadPart([
            'Bucket' => $bucket,
            'Key' => $keyname,
            'UploadId' => $uploadId,
            'PartNumber' =>$partNumber,
            'Body' => fread($file, 5 * 1024 * 1024),
        ]);
        $parts['Parts'][$partNumber] = [
            'PartNumber' => $partNumber,
            'ETag' => $uploadResult['ETag'],
        ];
        $partNumber++;

        echo "Uploading part {$partNumber} of {$filename}." . PHP_EOL;
    }
    fclose($file);
} catch (S3Exception $e) {
    $abortResult = $s3->abortMultipartUpload([
        'Bucket' => $bucket,
        'Key' => $keyname,
        'UploadId' => $uploadId
    ]);

    echo "Upload of {$filename} failed." . PHP_EOL;
}

$completeResult = $s3->completeMultipartUpload([
    'Bucket' => $bucket,
    'Key' => $keyname,
    'UploadId' => $uploadId,
    'MultipartUpload' => $parts,
]);

$url = $result['Location'];

echo "Uploaded {$filename} to {$url}." . PHP_EOL;

?>
