<?php

namespace Aloha\Config;

use Aloha\Config\Setting;
use Aloha\Factory\AlohaResponseFactory;
use Aloha\Helper\Mailer\AlohaMailer;
use Aura\Di\Container;
use Aura\Di\ContainerConfig;
use Slim\CallableResolver;
use Slim\Routing\RouteCollector;
use Slim\Routing\RouteParser;
use Slim\Routing\RouteResolver;

class AlohaContainerConfig extends ContainerConfig
{

    /**
     * @inheritDoc
     *
     * @param Container $container
     * @return void
     */
    public function define(Container $container): void
    {
        //setting
        $container->set("setting", $container->lazyNew(Setting::class));
        // router
        $container->set("responseFactory", $container->lazyNew(AlohaResponseFactory::class));
        $container->set("callableResolver", $container->lazyNew(CallableResolver::class));
        $container->set("routeCollector", $container->lazyNew(RouteCollector::class));
        $container->set("routeResolver", $container->lazyNew(RouteResolver::class));
        $container->set("routeParser", function () use ($container) {
            return $container->get("routeCollector")->getRouteParser();
        });
        //mailer
        $container->set("mailer", $container->lazyNew(AlohaMailer::class));

        // Type for injection
        $container->types[RouteParser::class] = $container->lazyGet("routeParser");
        $container->types[AlohaMailer::class] = $container->lazyGet("mailer");

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
     * @inheritDoc
     *
     * @param Container $container
     * @return void
     */
    public function modify(Container $container): void
    {
        $container->get("responseFactory")->setRouter($container->get("routeParser"));
    }
}
