<?php
/**
 * Created by PhpStorm.
 * User: seyfer
 * Date: 9/24/15
 * Time: 4:13 PM
 */

namespace ZendEnv\Console;

use ZendEnv\Tool\Environment;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use ZendBaseModel\PortAdapter\Event\EventManager\StaticEventManager;
use ZendMover\Copier;

/**
 * Class EnvCommand
 * @package ZendEnv\Console
 */
class EnvCommand extends Command
{
    protected function configure()
    {
        $this->setName('env:install')
            ->setHelp('Install project environment')
            ->setDescription('Install project environment')
            ->addArgument('env', InputArgument::REQUIRED, 'The name of env [stable, staging. dev]')
            ->addOption('dbuser', 'u', InputOption::VALUE_OPTIONAL, 'DB username')
            ->addOption('dbpswd', 'p', InputOption::VALUE_OPTIONAL, 'DB password')
            ->addOption('dbname', 'd', InputOption::VALUE_OPTIONAL, 'DB name');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return string
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $env = $input->getArgument('env');
        $dbu = $input->getOption('dbuser');
        $dbp = $input->getOption('dbpswd');
        $dbn = $input->getOption('dbname');

        try {
            $environment = new Environment($env, new Copier());
            $result = $environment->installEnv($env, $dbu, $dbp, $dbn);

            return $result ? "Success\n" : '';
        } catch (\Exception $e) {
            StaticEventManager::getInstance()->trigger('logException', $this, ['exception' => $e]);

            echo $e->getMessage() . "\n";
        }
    }
}
