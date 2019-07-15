<?php

namespace Ksb\Config;

use Aura\Di\Container;
use Aura\Di\ContainerConfig as AuraContainerConfig;
use Illuminate\Database\Capsule\Manager;
use Ksb\Controller\AuthController;
use Ksb\Controller\HomeController;
use Ksb\Logic\AuthLogic;
use Ksb\Logic\UserLogic;
use Slim\Views\Twig;
use Twig\Extension\DebugExtension;

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
            $view = new Twig($container->get("setting")->get("view.templateDir"), [
                "debug" => true,
            ]);
            $view->getEnvironment()->addGlobal("user", $container->get("auth")->getUser());

            $view->addExtension(new DebugExtension());
            return $view;
        });
        $container->types[Twig::class] = $container->lazyGet("view");

        // current user
        $container->set("auth", $container->lazyNew(AuthLogic::class));

        // Lazy new
        $container->set(HomeController::class, $container->lazyNew(HomeController::class));
        $container->set(AuthController::class, $container->lazyNew(AuthController::class));
        $container->set(UserLogic::class, $container->lazyNew(UserLogic::class));
        $container->set(AuthLogic::class, $container->lazyNew(AuthLogic::class));
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
        $container->get("auth");
    }
}
