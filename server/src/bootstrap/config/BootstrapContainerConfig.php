<?php

namespace Bootstrap\Config;

use Aura\Di\Container;
use Aura\Di\ContainerConfig;
use Bootstrap\Config\BootstrapSetting;
use Bootstrap\Factory\BootstrapResponseFactory;
use Bootstrap\Helper\Mailer\BootstrapMailer;
use Bootstrap\Middleware\CsrfGenerateMiddleware;
use Bootstrap\Middleware\FlashMiddleware;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\CallableResolver;
use Slim\Interfaces\CallableResolverInterface;
use Slim\Interfaces\RouteResolverInterface;
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

        //router
        $container->set("responseFactory", $container->lazyNew(BootstrapResponseFactory::class));
        $container->set("routeCollector", $container->lazyNew(RouteCollector::class));
        $container->set("callableResolver", function () use ($container) {
            return new CallableResolver($container);
        });

        $container->set("routeParser", function () use ($container) {
            return new RouteParser($container->get("routeCollector"));
        });
        $container->set("routeResolver", function () use ($container) {
            return new RouteResolver($container->get("routeCollector"));
        });

        // Type for injection
        $container->types[ResponseFactoryInterface::class] = $container->lazyGet("responseFactory");
        $container->types[CallableResolverInterface::class] = $container->lazyGet("callableResolver");
        $container->types[RouteResolverInterface::class] = $container->lazyGet("routeResolver");
        $container->types[RouteParser::class] = $container->lazyGet("routeParser");

        // Lazy new for auto-wiring
        $container->set(BootstrapMailer::class, $container->lazyNew(BootstrapMailer::class));
        $container->set(FlashMiddleware::class, $container->lazyNew(FlashMiddleware::class));
        $container->set(CsrfGenerateMiddleware::class, $container->lazyNew(CsrfGenerateMiddleware::class));
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
