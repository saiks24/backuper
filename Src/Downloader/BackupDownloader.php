<?php

namespace saiks24\Downloader;

use saiks24\Downloader\Strategy\DownloadStrategy;

interface BackupDownloader
{
    public static function create() : self ;

    public function backUpDownload(DownloadStrategy $strategy);
}