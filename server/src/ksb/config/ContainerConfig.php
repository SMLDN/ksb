<?php

namespace Ksb\Config;

use Aura\Di\Container;
use Aura\Di\ContainerConfig as AuraContainerConfig;
use Illuminate\Database\Capsule\Manager;
use Intervention\Image\ImageManager;
use Ksb\Logic\AuthLogic;

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

        // image manager
        $container->set("imageManager", function () {
            return new ImageManager([
                "driver" => "gd",
            ]);
        });

        // Type for injection
        $container->types[Manager::class] = $container->lazyGet("db");
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
