<?php

namespace Bootstrap\Config;

use Aura\Di\Container;
use Aura\Di\ContainerConfig;
use Bootstrap\Config\BootstrapSetting;
use Bootstrap\Factory\BootstrapResponseFactory;
use Bootstrap\Helper\Mailer\BootstrapMailer;
use Slim\CallableResolver;
use Slim\Routing\RouteCollector;
use Slim\Routing\RouteParser;
use Slim\Routing\RouteResolver;

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
        //setting
        $container->set("setting", $container->lazyNew(BootstrapSetting::class));

        // router
        $container->set("responseFactory", $container->lazyNew(BootstrapResponseFactory::class));
        $container->set("callableResolver", $container->lazyNew(CallableResolver::class));
        $container->set("routeCollector", $container->lazyNew(RouteCollector::class));
        $container->set("routeResolver", $container->lazyNew(RouteResolver::class));
        $container->set("routeParser", function () use ($container) {
            return $container->get("routeCollector")->getRouteParser();
        });

        //mailer
        $container->set("mailer", $container->lazyNew(BootstrapMailer::class));

        // Type for injection
        $container->types[RouteParser::class] = $container->lazyGet("routeParser");
        $container->types[BootstrapMailer::class] = $container->lazyGet("mailer");

        // Params
        $container->params[CallableResolver::class] = [
            "container" => $container,
        ];
        $container->params[RouteCollector::class] = [
            "responseFactory" => $container->lazyGet("responseFactory"),
            "callableResolver" => $container->lazyGet("callableResolver"),
            "container" => $container,
        ];
        $container->params[RouteResolver::class] = [
            "routeCollector" => $container->lazyGet("routeCollector"),
        ];
    }

    /**
     * Ghi đè hàm modfiy
     *
     * @param Container $container
     * @return void
     */
    public function modify(Container $container): void
    {
        $container->get("responseFactory")->setRouter($container->get("routeParser"));
    }
}
