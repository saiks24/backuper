<?php
namespace saiks24\Downloader;

use saiks24\Downloader\Strategy\DownloadStrategy;
use saiks24\FileSystem\BackupFile;

interface BackupDownloaderInterface
{
    public static function backUpDownload(DownloadStrategy $strategy): BackupFile;
}