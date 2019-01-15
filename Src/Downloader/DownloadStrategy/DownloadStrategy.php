<?php
namespace saiks24\Downloader\Strategy;

use saiks24\FileSystem\BackupFile;

interface DownloadStrategy
{
    public function download() : BackupFile;
}