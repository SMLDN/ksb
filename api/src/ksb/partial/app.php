<?php

use Aura\Di\ContainerBuilder;
use Bootstrap\AppBootstrap;
use Bootstrap\Config\BootstrapContainerConfig;
use Ksb\Config\ContainerConfig;
use Ksb\Config\ControllerConfig;
use Ksb\Config\RouteMiddlewareConfig;

// --Init app-- //

// Container
$builder = new ContainerBuilder();
$container = $builder->newConfiguredInstance([
    BootstrapContainerConfig::class,
    ContainerConfig::class,
    ControllerConfig::class,
    RouteMiddlewareConfig::class,
], $builder::AUTO_RESOLVE);

// Create app
$app = AppBootstrap::create($container);
