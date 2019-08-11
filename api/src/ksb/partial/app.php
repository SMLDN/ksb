<?php

use Aloha\AppAloha;
use Aloha\Config\AlohaContainerConfig;
use Aura\Di\ContainerBuilder;
use Ksb\Config\ContainerConfig;
use Ksb\Config\ControllerConfig;
use Ksb\Config\RouteMiddlewareConfig;

// --Init app-- //

// Container
$builder = new ContainerBuilder();
$container = $builder->newConfiguredInstance([
    AlohaContainerConfig::class,
    ContainerConfig::class,
    ControllerConfig::class,
    RouteMiddlewareConfig::class,
], $builder::AUTO_RESOLVE);

// Create app
$app = AppAloha::create($container);
