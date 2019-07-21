<?php

use Bootstrap\Middleware\AuthMiddleware;
use Bootstrap\Middleware\FlashMiddleware;
use Slim\Middleware\ErrorMiddleware;

$setting = $container->get("setting");

$app->add(new ErrorMiddleware($app->getCallableResolver(), $app->getResponseFactory(),
    $setting->get("errorMiddleware.displayErrorDetails"),
    $setting->get("errorMiddleware.logErrors"),
    $setting->get("errorMiddleware.logErrorDetails")));

$app->add($container->get(AuthMiddleware::class));

$app->add($container->get(FlashMiddleware::class));
