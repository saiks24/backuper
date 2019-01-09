<?php

namespace saiks24\Downloader;


use saiks24\Downloader\Strategy\DownloadStrategy;
use saiks24\FileSystem\BackupFile;
// TODO Maybe refactor to Observer class
class BackupDownloader implements BackupDownloaderInterface
{

    public function backUpDownload(String $pathToTmpFile, DownloadStrategy $strategy): BackupFile
    {
        return $strategy->download($pathToTmpFile);
    }
}