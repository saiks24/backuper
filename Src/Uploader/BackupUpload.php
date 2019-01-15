<?php

namespace saiks24\Uploader;


use saiks24\Uploader\Strategy\UploadStrategy;

class BackupUpload
{
    public static function uploadBackup(UploadStrategy $strategy)
    {
        $strategy->upload();
    }
}