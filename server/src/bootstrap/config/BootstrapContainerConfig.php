<?php

namespace Bootstrap\Config;

use Aura\Di\Container;
use Aura\Di\ContainerConfig;

class BootstrapContainerConfig extends ContainerConfig
{

    /**
     * Ghi đè hàm define
     *
     * @param Container $container
     * @return void
     */
    public function define(Container $container): void
    {
        $container->set("settings", $container->lazyNew(BootstrapSetting::class));
    }

    /**
     * Ghi đè hàm modfiy
     *
     * @param Container $container
     * @return void
     */
    public function modify(Container $container): void
    {

    }
}
