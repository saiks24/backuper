<?php

namespace saiks24\Downloader;


use saiks24\Downloader\Strategy\DownloadStrategy;
use saiks24\FileSystem\BackupFile;
// TODO Maybe refactor to Observer class
class BackupDownloader implements BackupDownloaderInterface
{

    public static function backUpDownload(DownloadStrategy $strategy): BackupFile
    {
        return $strategy->download();
    }
}