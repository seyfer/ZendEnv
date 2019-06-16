<?php
/**
 * Created by PhpStorm.
 * User: seyfer
 * Date: 2/17/16
 */

namespace ZendEnv\Representation;

use ZendBaseModel\Domain\Enum\BaseEnum;

/**
 * Class EnvNameEnum
 * @package ZendEnv\Representation
 */
class EnvNameEnum extends BaseEnum
{
    const STABLE = 'stable';
    const STAGING = 'staging';
    const DEV = 'dev';
    const LOCAL = 'local';
}
