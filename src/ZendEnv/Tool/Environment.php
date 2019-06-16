<?php
/**
 * Created by PhpStorm.
 * User: seyfer
 * Date: 9/23/15
 * Time: 11:08 PM
 */

namespace ZendEnv\Tool;

use ZendEnv\Validation\ValidationException;
use ZendMover\Command\MoveCommand;
use ZendMover\MoverInterface;

/**
 * Class Environment
 * @package ZendEnv\Tool
 */
class Environment
{
    const ENV_STABLE = 'stable';
    const ENV_STAGING = 'staging';
    const ENV_DEV = 'dev';
    const ENV_LOCAL = 'loc';

    /**
     * @var array
     */
    private $availableEnvs = [
        self::ENV_STABLE, self::ENV_STAGING, self::ENV_DEV, self::ENV_LOCAL,
    ];

    /**
     * @var string
     */
    private $configPath;

    /**
     * @var string
     */
    private $env = '';

    /**
     * @var MoverInterface
     */
    private $copier;

    /**
     * @param string $env
     * @param MoverInterface $copier
     * @throws ValidationException
     */
    public function __construct($env, MoverInterface $copier)
    {
        $this->configPath = __DIR__ . '/../../../../../config/autoload/';

        $this->setEnv($env);
        $this->setCopier($copier);
    }

    /**
     * @param null $env
     * @param null $dbu
     * @param null $dbp
     * @param null $dbn
     * @return bool
     * @throws ValidationException
     */
    public function installEnv($env = null, $dbu = null, $dbp = null, $dbn = null)
    {
        if ($env) {
            $this->setEnv($env);
        }

        //check config file
        $configFile = $this->configPath . 'env.' . $env . '.php';
        if (!file_exists($configFile)) {
            throw new \RuntimeException('Config file ' . $configFile . ' not exist');
        }
        $localConfigFile = 'env.local.php';
        $localConfigFilePath = $this->configPath . $localConfigFile;

        $moveCommand = new MoveCommand($this->copier);
        $moveCommand->setFromDirectory($this->configPath)
            ->setToDirectory($this->configPath)
            ->addFileToMove(new \SplFileInfo($configFile))
            ->setDestinationFileName($localConfigFile);

        $moveCommand->execute();

        if ($dbu && $dbp && $dbn) {
            $envConfigFileContent = file_get_contents($localConfigFilePath);
            $envConfigFileContentR = preg_replace(
                ['/{dbu}/', '/{dbp}/', '/{dbn}/'],
                [$dbu, $dbp, $dbn],
                $envConfigFileContent
            );

            file_put_contents($localConfigFilePath, $envConfigFileContentR);

            return true;
        }

        if ($dbu && $dbp) {
            $envConfigFileContent = file_get_contents($localConfigFilePath);
            $envConfigFileContentR = preg_replace(
                ['/{dbu}/', '/{dbp}/'],
                [$dbu, $dbp],
                $envConfigFileContent
            );

            file_put_contents($localConfigFilePath, $envConfigFileContentR);

            return true;
        }

        if ($dbp) {
            $envConfigFileContent = file_get_contents($localConfigFilePath);
            $envConfigFileContentR = preg_replace(
                '/{dbp}/',
                $dbp,
                $envConfigFileContent
            );

            file_put_contents($localConfigFilePath, $envConfigFileContentR);

            return true;
        }

        return true;
    }

    /**
     * @return string
     */
    public function getEnv()
    {
        return $this->env;
    }

    /**
     * @param string $env
     * @throws ValidationException
     */
    public function setEnv($env)
    {
        if (!in_array($env, $this->availableEnvs)) {
            throw new ValidationException('Wrong env value');
        }

        $this->env = $env;
    }

    /**
     * @return MoverInterface
     */
    public function getCopier()
    {
        return $this->copier;
    }

    /**
     * @param MoverInterface $copier
     */
    public function setCopier($copier)
    {
        $this->copier = $copier;
    }
}
