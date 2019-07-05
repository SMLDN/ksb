<?php

use Aura\Di\ContainerBuilder;
use Bootstrap\Config\BootstrapContainerConfig;
use Ksb\Config\ContainerConfig;
use Slim\Factory\AppFactory;

require __DIR__ . "/../../vendor/autoload.php";

session_start();

$bootstrapDir = __DIR__ . "/../bootstrap/";

$builder = new ContainerBuilder();
$container = $builder->newConfiguredInstance([BootstrapContainerConfig::class, ContainerConfig::class], $builder::AUTO_RESOLVE);

AppFactory::setContainer($container);
$app = AppFactory::create();

//Config app middleware
require_once $bootstrapDir . "middleware.php";

// Config controller
require_once $bootstrapDir . "controller.php";

$app->run();
