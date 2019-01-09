<?php
namespace saiks24\FileSystem;

class LocalBackUpFile implements BackupFile
{
    private $path;
    private $name;
    private $size;

    /**
     * LocalBackUpFile constructor.
     * @param $path
     * @param $name
     * @param $size
     */
    public function __construct($path, $name, $size)
    {
        $this->path = $path;
        $this->name = $name;
        $this->size = $size;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getName(): string
    {
        return $this->getName();
    }

    public function getPath(): string
    {
        return $this->getPath();
    }

}