<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../vendor/autoload.php';
$app = \saiks24\App\Application::getInstance();
//var_dump($app->getUploadType());
//var_dump($app->getDownloadType());
//var_dump($app->getCreateType());
//var_dump($app->getConfig());
echo 'Start create backup....' . PHP_EOL;
switch ($app->getCreateType()) {
    case 'ssh_exec':
        \saiks24\CreateBackup\BackUpCreator::createBackUp(
            new \saiks24\CreateBackup\Strategy\SSHBackup($app)
        );
        break;
}
echo 'Backup on remote host success created' . PHP_EOL;
echo 'Start downloadBackup...' . PHP_EOL;
switch ($app->getDownloadType()) {
    case 'ssh':
        \saiks24\Downloader\BackupDownloader::backUpDownload(new \saiks24\Downloader\Strategy\SSHDownloadStrategy($app));
        break;
}
echo 'Backup success download' . PHP_EOL;
echo 'Start backup upload...' . PHP_EOL;
switch ($app->getUploadType()) {
    case 'yandex_disk':
        \saiks24\Uploader\BackupUpload::uploadBackup(new \saiks24\Uploader\Strategy\YandexDiskUploadStrategy($app));
        break;
}
echo 'End!' . PHP_EOL;
//$config = json_decode(
//    file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'configs/ssh.json'),
//    true
//);
//if(empty($config)) {
//    echo 'Wrong config' . PHP_EOL;
//    exit(-1);
//}
//var_dump($config);
//// TODO Конфиги в отдельную сущность
//$backupDownLoad = new \saiks24\Downloader\BackupDownloader();
//$strategy = new \saiks24\Downloader\Strategy\SSHDownloadStrategy(
//    $config['address'],
//    $config['port'],
//    $config['login'],
//    $config['password'],
//    $config['filePath']
//);
//try {
//    // Создаем бекап
////    \saiks24\CreateBackup\BackUpCreator::createBackUp(new \saiks24\CreateBackup\SSHBackup(
////        $config['address'],
////        $config['port'],
////        '/home/u160569/delosystems.ru/www/land/',
////        '/home/u160569/delosystems.ru/www/files.tar.bz2',
////        $config['login'],
////        $config['password']
////    ));
//    // Скачиваем
////    $resultFile = $backupDownLoad->backUpDownlo   ad('./result',$strategy);
////    var_dump($resultFile);
//    // Грузим куда нибудь
//    \saiks24\Uploader\BackupUpload::uploadBackup(new \saiks24\Uploader\Strategy\YandexDiskUploadStrategy());
//
//} catch (Exception $e) {
//    echo get_class($e) . PHP_EOL;
//    echo $e->getMessage() . PHP_EOL;
//    exit(-1);
//}