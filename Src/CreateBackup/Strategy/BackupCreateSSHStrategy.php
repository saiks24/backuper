<?php
namespace saiks24\CreateBackup\Strategy;

use saiks24\App\Application;
use saiks24\CreateBackup\CreateBackup;

class SSHBackup implements CreateBackup
{


    private $address;
    private $port;
    /** @var String Директория для бекапа */
    private $dirToBackup;
    /** @var String Путь до результирующего архива с бекаом */
    private $resultDirectory;
    private $login;
    private $password;

    /**
     * SSHBackup constructor.
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        $config = $application->getConfig();
        $this->address = $config['sshConfig']['address'];
        $this->port = $config['sshConfig']['port'];
        $this->dirToBackup = $config['sshConfig']['directoryToBackup'];
        $this->resultDirectory = $config['backupPaths']['remotePath'];
        $this->login = $config['sshConfig']['login'];
        $this->password = $config['sshConfig']['password'];
    }


    /**
     * @return resource
     */
    private function createSSHConnection()
    {
        $connect = \ssh2_connect($this->address,$this->port);
        ssh2_auth_password($connect, $this->login, $this->password);
        return $connect;
    }


    public function makeBackUp()
    {
        $sshConnection = $this->createSSHConnection();
        $command = "tar -cvjf " . $this->resultDirectory . ' ' . $this->dirToBackup;
        $result = ssh2_exec($sshConnection,$command);
        ssh2_exec($sshConnection,'chmod 775 ' . $this->resultDirectory . ' ' . $this->dirToBackup);
        stream_set_blocking($result, true);
        echo stream_get_contents($result);
        fclose($result);
    }
}