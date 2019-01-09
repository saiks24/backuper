<?php
namespace saiks24\Uploader;

use saiks24\Uploader\Strategy\UploadStrategy;

interface BackupUploader
{
    public static function create() : self ;
    public static function upload(UploadStrategy $strategy);
}