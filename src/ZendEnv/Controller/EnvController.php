<?php
/**
 * Created by PhpStorm.
 * User: seyfer
 * Date: 9/23/15
 * Time: 11:00 PM
 */

namespace ZendEnv\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use ZendBaseModel\PortAdapter\Event\EventManager\StaticEventManager;
use ZendEnv\Tool\Environment;
use ZendMover\Copier;

/**
 * Class EnvController
 * @package ZendEnv\Controller
 */
class EnvController extends AbstractActionController
{
    /**
     * @return string
     */
    public function installAction()
    {
        $env = $this->getRequest()->getParam('env');
        $dbu = $this->getRequest()->getParam('dbu');
        $dbp = $this->getRequest()->getParam('dbp');
        $dbn = $this->getRequest()->getParam('dbn');

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
