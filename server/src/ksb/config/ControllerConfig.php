<?php

namespace Ksb\Config;

use Aura\Di\Container;
use Aura\Di\ContainerConfig as AuraContainerConfig;
use Ksb\Controller\AuthController;
use Ksb\Controller\HomeController;
use Ksb\Controller\SheetAttachController;
use Ksb\Controller\SheetController;
use Ksb\Controller\UserController;

class ControllerConfig extends AuraContainerConfig
{
    /**
     * @inheritDoc
     *
     * @param Container $container
     * @return void
     */
    public function define(Container $container): void
    {
        $container->set(HomeController::class, $container->lazyNew(HomeController::class));
        $container->set(AuthController::class, $container->lazyNew(AuthController::class));
        $container->set(UserController::class, $container->lazyNew(UserController::class));
        $container->set(SheetController::class, $container->lazyNew(SheetController::class));
        $container->set(SheetAttachController::class, $container->lazyNew(SheetAttachController::class));
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
