<?php
/**
 * Created by PhpStorm.
 * User: seyfer
 * Date: 9/24/15
 * Time: 4:13 PM
 */
define('APPLICATION_DIR', dirname(__DIR__ . '/../../../'));
date_default_timezone_set('Europe/Amsterdam');

$vendor = file_exists(APPLICATION_DIR . '/vendor/autoload.php') ?
    APPLICATION_DIR . '/vendor/autoload.php' : './vendor';

require_once $vendor;

if (file_exists(APPLICATION_DIR . '/config/development.config.php')) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    define('DEVELOPMENT_MODE', true);
}

use Symfony\Component\Console\Application;

$application = new Application('myapp');
$application->add(new \ZendEnv\Console\EnvCommand());
$application->run();
