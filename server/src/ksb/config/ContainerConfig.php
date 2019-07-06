<?php

namespace Ksb\Config;

use Aura\Di\Container;
use Aura\Di\ContainerConfig as AuraContainerConfig;
use Ksb\Controller\HomeController;
use Slim\Views\Twig;

class ContainerConfig extends AuraContainerConfig
{
    /**
     * Ghi đè hàm define
     *
     * @param Container $container
     * @return void
     */
    public function define(Container $container): void
    {
        $container->set("view", function () use ($container) {
            $view = new Twig($container->get("settings")->get("view.templateDir"));
            return $view;
        });
        $container->types[Twig::class] = $container->lazyGet("view");
        $container->set(HomeController::class, $container->lazyNew(HomeController::class));
    }

    /**
     * Ghi đè hàm modify
     *
     * @param Container $container
     * @return void
     */
    public function modify(Container $container): void
    {

    }
}
