<?php

namespace Ksb\Config;

use Aura\Di\Container;
use Aura\Di\ContainerConfig as AuraContainerConfig;
use Bootstrap\Middleware\AuthMiddleware;
use Bootstrap\Middleware\FlashMiddleware;
use Illuminate\Database\Capsule\Manager;
use Ksb\Controller\AuthController;
use Ksb\Controller\HomeController;
use Ksb\Controller\UserController;
use Ksb\Helper\Extension\KsbTwigExtension;
use Ksb\Helper\Flash;
use Ksb\Logic\AuthLogic;
use Ksb\Logic\UserLogic;
use Slim\Psr7\Uri;
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

        // auth
        $container->set("auth", $container->lazyNew(AuthLogic::class));

        // view
        $container->set("view", function () use ($container) {
            $view = new Twig($container->get("setting")->get("view.templateDir"), [
                "debug" => getenv("DEBUG"),
            ]);
            if (getenv("DEBUG")) {
                $view->addExtension(new DebugExtension());
            }
            $view->addExtension(new KsbTwigExtension($container->get("routeParser"), new Uri($_SERVER["REQUEST_SCHEME"], $_SERVER["HTTP_HOST"])));
            return $view;
        });

        // Type for injection
        $container->types[Twig::class] = $container->lazyGet("view");
        $container->types[AuthLogic::class] = $container->lazyGet("auth");

        // Lazy new for auto-wiring
        $container->set(HomeController::class, $container->lazyNew(HomeController::class));
        $container->set(AuthController::class, $container->lazyNew(AuthController::class));
        $container->set(UserController::class, $container->lazyNew(UserController::class));
        $container->set(UserLogic::class, $container->lazyNew(UserLogic::class));
        $container->set(Flash::class, $container->lazyNew(Flash::class));
        $container->set(AuthMiddleware::class, $container->lazyNew(AuthMiddleware::class));
        $container->set(FlashMiddleware::class, $container->lazyNew(FlashMiddleware::class));

        //Params
        $container->params[AuthMiddleware::class]["authLogic"] = $container->lazyGet("auth");
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
