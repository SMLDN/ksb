<?php

namespace Ksb\Config;

use Aura\Di\Container;
use Aura\Di\ContainerConfig as AuraContainerConfig;
use Ksb\Middleware\Route\AuthPermissionMiddleware;
use Ksb\Middleware\Route\GuestPermissionMiddleware;

class RouteMiddlewareConfig extends AuraContainerConfig
{
    /**
     * @inheritDoc
     *
     * @param Container $container
     * @return void
     */
    public function define(Container $container): void
    {
        $container->set(GuestPermissionMiddleware::class, $container->lazyNew(GuestPermissionMiddleware::class));
        $container->set(AuthPermissionMiddleware::class, $container->lazyNew(AuthPermissionMiddleware::class));
    }

    /**
     * @inheritDoc
     *
     * @param Container $container
     * @return void
     */
    public function modify(Container $container): void
    {
    }
}
