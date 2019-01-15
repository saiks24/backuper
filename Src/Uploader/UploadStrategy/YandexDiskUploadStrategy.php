<?php

namespace saiks24\Uploader\Strategy;


use saiks24\App\Application;
use Yandex\Disk\DiskClient;
// TODO Реализовать проверку на оставшееся место на диске (сравнить размер бекапа и оставнегошся в ЯД места)
class YandexDiskUploadStrategy implements UploadStrategy
{

    private $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    public function upload()
    {
        $config = $this->application->getConfig();
        // TODO Увести инстанцирование класса диска отсюда в абстрацкию, явно у всех внешних дисков будет метод uload или аналоги, то почему и нет
        $yandexDisk = new DiskClient($config['yandexDiskConfigs']['token']);
        $yandexDisk->setServiceScheme(DiskClient::HTTPS_SCHEME);
        var_dump($config['backupPaths']);
        $yandexDisk->uploadFile($config['yandexDiskConfigs']['backupDirectory'],
            [
                'name' => $config['backupPaths']['name'],
                'path' => $config['backupPaths']['localPath'].$config['backupPaths']['name'],
                'size' => filesize( $config['backupPaths']['localPath'].$config['backupPaths']['name'])
            ]
        );


    }

}