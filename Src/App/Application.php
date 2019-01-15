<?php
namespace saiks24\App;
class Application
{
    /** @var array */
    private $config;
    /** @var string  */
    private $createType;
    /** @var string  */
    private $downloadType;
    /** @var string  */
    private $uploadType;
    /** @var self */
    private static $instance = null;

    private function __construct()
    {
        $pathToconfig = __DIR__.DIRECTORY_SEPARATOR.'../../configs/baseconfig.json';
        if(!is_file($pathToconfig) || !is_readable($pathToconfig)) {
            throw new \saiks24\Exceptions\ConfigFileNotFound();
        }
        $config = json_decode(
            file_get_contents($pathToconfig),
            true
        );
        $this->config = (array)$config;
        if(!$this->checkConfig()) {
            throw new \saiks24\Exceptions\WrongConfigStructure();
        }
        $this->createType = (string)$this->config['createBackup']['type'];
        $this->downloadType = (string)$this->config['downloadBackup']['type'];
        $this->uploadType = (string)$this->config['uploadBackUp']['type'];
    }

    public static function getInstance()
    {
        if(self::$instance !== null) {
            return self::$instance;
        }
        return new Application();
    }

    /**
     * @return string
     */
    public function getCreateType(): string
    {
        return $this->createType;
    }

    /**
     * @return string
     */
    public function getDownloadType(): string
    {
        return $this->downloadType;
    }

    /**
     * @return string
     */
    public function getUploadType(): string
    {
        return $this->uploadType;
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    private function checkConfig() : bool
    {
        if(
            empty($this->config['createBackup']['type']) ||
            empty($this->config['downloadBackup']['type']) ||
            empty($this->config['uploadBackUp']['type'])
        ) {
            return false;
        }
        return true;
    }
}