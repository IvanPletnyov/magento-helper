<?php

declare(strict_types=1);

define('PD', dirname(__FILE__, 2));
define('DS', DIRECTORY_SEPARATOR);

require_once PD . '/lib/Framework/autoload.php';
require 'wrap_functions.php';
require 'additional_functions.php';

define(
    'DIRECTORIES_WITH_VENDORS',
    [
        PD . DS . 'lib',
        PD . DS . 'app' . DS . 'code',
    ]
);
define(
    'OBJECT_MANAGER_CONFIG_PATHS',
    [
        PD . DS . 'lib' .DS . 'Framework' . DS . '*' . DS . 'Config' . DS . 'ObjectManagerConfig.php',
        PD . DS . 'app' . DS . 'code' . DS . '*' . DS . '*' . DS . 'Config' . DS . 'ObjectManagerConfig.php',
    ]
);

require_once PD . '/lib/Framework/ObjectManager/Service/BuildObjectManager.php';

error_reporting(E_ALL);
ini_set('display_errors', '1');

date_default_timezone_set('UTC');

$autoload = new autoload();
$autoload->init();
