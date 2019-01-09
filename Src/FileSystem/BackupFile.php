<?php

namespace saiks24\FileSystem;

interface BackupFile
{
    public function getSize();

    public function getName();

    public function getPathInfo();
}