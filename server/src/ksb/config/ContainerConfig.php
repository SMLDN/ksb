<?php

namespace Ksb\Config;

use Aura\Di\Container;
use Aura\Di\ContainerConfig as AuraContainerConfig;
use Illuminate\Database\Capsule\Manager;
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
        // db
        $container->set("db", function () use ($container) {
            $capsule = new Manager;
            $dbConfig = $container->get("setting")->get("db");
            $capsule->addConnection($dbConfig);

            $capsule->setAsGlobal();
            $capsule->bootEloquent();

            return $capsule;
        });
        $container->types[Manager::class] = $container->lazyGet("db");

        // view
        $container->set("view", function () use ($container) {
            $view = new Twig($container->get("setting")->get("view.templateDir"));
            return $view;
        });
        $container->types[Twig::class] = $container->lazyGet("view");

        // Lazy new
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
        $container->get("db");
    }
}
