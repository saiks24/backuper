<?php

namespace saiks24\CreateBackup;


class BackUpCreator
{

    public static function createBackUp(CreateBackup $createStrategy)
    {
            $createStrategy->makeBackUp();
    }
}