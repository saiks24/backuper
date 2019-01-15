<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../vendor/autoload.php';
$app = \saiks24\App\Application::getInstance();
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