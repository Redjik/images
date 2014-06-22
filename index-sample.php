<?php
defined('APP_PATH') or define('APP_PATH',__DIR__.'/app');

include(__DIR__.'/vendor/autoload.php');
$config = include(__DIR__.'/config/config.php');
$container = new app\Core\Container($config);
$container->controller->actionIndex();
$container->response->send();