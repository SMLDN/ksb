<?php

use Bootstrap\Middleware\AuthMiddleware;
use Slim\Middleware\ErrorMiddleware;

$setting = $container->get("setting");

$app->add(new ErrorMiddleware($app->getCallableResolver(), $app->getResponseFactory(),
    $setting->get("errorMiddleware.displayErrorDetails"),
    $setting->get("errorMiddleware.logErrors"),
    $setting->get("errorMiddleware.logErrorDetails")));

$app->add(new AuthMiddleware($container->get("auth")));
