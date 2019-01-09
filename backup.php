<?php
require_once __DIR__.DIRECTORY_SEPARATOR.'vendor/autoload.php';

$config = json_decode(
    file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'configs/ssh.json'),
    true
);
if(empty($config)) {
    echo 'Wrong config' . PHP_EOL;
    exit(-1);
}
var_dump($config);
$backupDownLoad = new \saiks24\Downloader\BackupDownloader();
$strategy = new \saiks24\Downloader\Strategy\SSHDownloadStrategy(
    $config['address'],
    $config['port'],
    $config['login'],
    $config['password'],
    $config['filePath']
);
try {
    $resultFile = $backupDownLoad->backUpDownload('./result',$strategy);
    var_dump($resultFile);
} catch (Exception $e) {
    echo get_class($e) . PHP_EOL;
    echo $e->getMessage() . PHP_EOL;
    exit(-1);
}