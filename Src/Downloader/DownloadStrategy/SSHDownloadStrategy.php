<?php
/**
 * Created by PhpStorm.
 * User: mikhail
 * Date: 09.01.19
 * Time: 22:49
 */

namespace saiks24\Downloader\Strategy;


use saiks24\App\Application;
use saiks24\Exceptions\ConnectionToSSHHostFiled;
use saiks24\Exceptions\FailedToLoadFileFromHost;
use saiks24\Exceptions\WrongAuthOnSSHHost;
use saiks24\Exceptions\WrongTmpPathOnLocalStorage;
use saiks24\FileSystem\BackupFile;
use saiks24\FileSystem\FileSystemHelper;
use saiks24\FileSystem\LocalBackUpFile;

class SSHDownloadStrategy implements DownloadStrategy
{

    private $address;
    private $port;
    private $login;
    private $password;
    private $filePath;
    private $localPath;

    /**
     * SSHDownloadStrategy constructor.
     * @param Application $application
     */
    public function __construct(Application $application/*String $address,int $port = 22, String $login, String $password, String $filePath*/)
    {
        $config = $application->getConfig();
        $this->address = $config['sshConfig']['address'];
        $this->port = $config['sshConfig']['port'];
        $this->login = $config['sshConfig']['login'];
        $this->password = $config['sshConfig']['password'];
        $this->filePath = $config['backupPaths']['remotePath'];
        $this->localPath = $config['backupPaths']['localPath'].$config['backupPaths']['name'];
    }

    /**
     * @return BackupFile
     * @throws ConnectionToSSHHostFiled
     * @throws FailedToLoadFileFromHost
     * @throws WrongAuthOnSSHHost
     */
    public function download() : BackupFile
    {
        if(!$this->checkConnection()) {
            throw new ConnectionToSSHHostFiled();
        }
        $connection = $this->getConnection();
        if(!ssh2_auth_password($connection, $this->login, $this->password)) {
            throw new WrongAuthOnSSHHost();
        }
        if(!is_file($this->localPath)) {
            touch($this->localPath);
        }
        if(!ssh2_scp_recv($connection,$this->filePath,$this->localPath)) {
            throw new FailedToLoadFileFromHost();
        }
        return new LocalBackUpFile(
            $this->localPath,
            basename($this->localPath),
            filesize($this->localPath)
        );
    }

    /**
     * @return resource
     */
    private function getConnection()
    {
        return \ssh2_connect($this->address,$this->port);
    }

    /**
     * @return bool
     */
    private function checkConnection() : bool
    {
        $connect = \ssh2_connect($this->address,$this->port);
        if(!$connect) {
            return false;
        }
        return (bool)$connect;
    }
}