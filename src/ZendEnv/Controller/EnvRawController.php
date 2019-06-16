<?php
/**
 * Created by PhpStorm.
 * User: seyfer
 * Date: 9/24/15
 * Time: 3:25 PM
 */

namespace ZendEnv\Controller;

use Zend\Mvc\Controller\AbstractController;
use Zend\Mvc\MvcEvent;
use ZendBaseModel\PortAdapter\Event\EventManager\StaticEventManager;
use ZendEnv\Tool\Environment;
use ZendMover\Copier;

/**
 * Class EnvRawController
 * @package ZendEnv\Controller
 */
class EnvRawController extends AbstractController
{

    /**
     * Execute the request
     *
     * @param MvcEvent $e
     * @return mixed
     */
    public function onDispatch(MvcEvent $e)
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
