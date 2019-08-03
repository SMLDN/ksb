<?php

namespace Ksb\Config;

use Aptoma\Twig\Extension\MarkdownEngine\MichelfMarkdownEngine;
use Aptoma\Twig\Extension\MarkdownExtension;
use Aura\Di\Container;
use Aura\Di\ContainerConfig as AuraContainerConfig;
use Bootstrap\Helper\SessionManager;
use Illuminate\Database\Capsule\Manager;
use Intervention\Image\ImageManager;
use Ksb\Logic\AuthLogic;
use Slim\Views\Twig;
use Twig\Extension\DebugExtension;

class ContainerConfig extends AuraContainerConfig
{
    /**
     * @inheritDoc
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
            $view->addExtension(new MarkdownExtension(new MichelfMarkdownEngine));
            $view->getEnvironment()->addGlobal("csrfKey", SessionManager::get("csrf_key"));
            $view->getEnvironment()->addGlobal("csrfToken", SessionManager::get("csrf_token"));
            return $view;
        });

        // image manager
        $container->set("imageManager", function () {
            return new ImageManager([
                "driver" => "gd",
            ]);
        });

        // Type for injection
        $container->types[Manager::class] = $container->lazyGet("db");
        $container->types[Twig::class] = $container->lazyGet("view");
        $container->types[AuthLogic::class] = $container->lazyGet("auth");
        $container->types[ImageManager::class] = $container->lazyGet("imageManager");
    }

    /**
     * @inheritDoc
     *
     * @param Container $container
     * @return void
     */
    public function modify(Container $container): void
    {
        $container->get("db");
    }
}
