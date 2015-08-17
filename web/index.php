<?php

/**
 * Единая точка входа
 *
 * @package Gksoft\Controllers
 * @author  Galina Kozyreva <kozyreva.galinka@gmail.com>
 */

define('PROJECT_PATH', realpath(__DIR__.'/../'));
set_include_path(get_include_path() . PATH_SEPARATOR . PROJECT_PATH);

require_once 'vendor/autoload.php';

$app = new Silex\Application(require_once 'configs/app_config.php');

require_once 'app/di.php';
require_once 'app/routing.php';

$app->run();