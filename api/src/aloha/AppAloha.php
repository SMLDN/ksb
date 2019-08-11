<?php

namespace Aloha;

use Psr\Container\ContainerInterface;
use Slim\Factory\AppFactory;

class AppAloha
{

    /**
     * Khởi tạo instance của Slim
     *
     * @param ContainerInterface $container
     * @return void
     */
    public static function create(ContainerInterface $container)
    {
        if (!$container || !$container->has("responseFactory")
            || !$container->has("callableResolver") || !$container->has("routeCollector")
            || !$container->has("routeResolver")) {
            throw new LogicException;
        }

        AppFactory::setResponseFactory($container->get("responseFactory"));
        AppFactory::setContainer($container);
        AppFactory::setCallableResolver($container->get("callableResolver"));
        AppFactory::setRouteCollector($container->get("routeCollector"));
        AppFactory::setRouteResolver($container->get("routeResolver"));
        $app = AppFactory::create();
        return $app;
    }
}
