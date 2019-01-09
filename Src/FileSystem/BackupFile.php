<?php

namespace saiks24\FileSystem;

interface BackupFile
{
    public function getSize() : int;

    public function getName() : string;

    public function getPath() : string;
}