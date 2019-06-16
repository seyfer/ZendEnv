<?php
/**
 * Created by PhpStorm.
 * User: seyfer
 * Date: 12/10/15
 */

namespace ZendEnv;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

/**
 * Class Module
 * @package Env
 */
class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ServiceProviderInterface
{
    /**
     * @inheritdoc
     */
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function getConfig()
    {
        $moduleConfig = require_once __DIR__ . '/config/module.config.php';

        return $moduleConfig;
    }

    /**
     * @inheritdoc
     */
    public function getServiceConfig()
    {
        return [];
    }
}
