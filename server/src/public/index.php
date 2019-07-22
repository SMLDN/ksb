<?php

use Aura\Di\ContainerBuilder;
use Bootstrap\AppBootstrap;
use Bootstrap\Config\BootstrapContainerConfig;
use Ksb\Config\ContainerConfig;

require __DIR__ . "/../../vendor/autoload.php";

$partialDir = __DIR__ . "/../ksb/partial/";

// Init
require_once $partialDir . "init.php";

// Container
$builder = new ContainerBuilder();
$container = $builder->newConfiguredInstance([BootstrapContainerConfig::class, ContainerConfig::class], $builder::AUTO_RESOLVE);

// Create app
$app = AppBootstrap::createNewApp($container);

//Config app middleware
require_once $partialDir . "middleware.php";

// Config controller
require_once $partialDir . "controller.php";

$app->run();
