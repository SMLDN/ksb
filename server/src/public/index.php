<?php

use Aura\Di\ContainerBuilder;
use Bootstrap\AppBootstrap;
use Bootstrap\Config\BootstrapContainerConfig;
use Bootstrap\Helper\SessionManager;
use Ksb\Config\ContainerConfig;

require __DIR__ . "/../../vendor/autoload.php";

SessionManager::start();

$partialDir = __DIR__ . "/../ksb/partial/";

$builder = new ContainerBuilder();
$container = $builder->newConfiguredInstance([BootstrapContainerConfig::class, ContainerConfig::class], $builder::AUTO_RESOLVE);

$app = AppBootstrap::createNewApp($container);

//Config app middleware
require_once $partialDir . "middleware.php";

// Config controller
require_once $partialDir . "controller.php";

$app->run();
