<?php
/**
 * Created by PhpStorm.
 * User: mikhail
 * Date: 09.01.19
 * Time: 22:49
 */

namespace saiks24\Downloader\Strategy;


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

    public function __construct(String $address,int $port = 22, String $login, String $password, String $filePath)
    {
        $this->address = $address;
        $this->port = $port;
        $this->login = $login;
        $this->password = $password;
        $this->filePath = $filePath;
    }

    /**
     * @param String $pathToTmpFile
     * @return BackupFile
     * @throws ConnectionToSSHHostFiled
     * @throws FailedToLoadFileFromHost
     * @throws WrongAuthOnSSHHost
     */
    public function download(String $pathToTmpFile) : BackupFile
    {
        if(!$this->checkConnection()) {
            throw new ConnectionToSSHHostFiled();
        }
        $connection = $this->getConnection();
        if(!ssh2_auth_password($connection, $this->login, $this->password)) {
            throw new WrongAuthOnSSHHost();
        }
        if(!ssh2_scp_recv($connection,$this->filePath,$pathToTmpFile)) {
            throw new FailedToLoadFileFromHost();
        }
        return new LocalBackUpFile(
            $pathToTmpFile,
            basename($pathToTmpFile),
            filesize($pathToTmpFile)
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
        // TODO Function undefined?!
        //ssh2_disconnect($connect);
        return (bool)$connect;
    }
}