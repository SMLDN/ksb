<?php

use Slim\Middleware\ErrorMiddleware;

$settings = $container->get("settings");

$app->add(new ErrorMiddleware($app->getCallableResolver(), $app->getResponseFactory(),
    $settings->get("errorMiddleware.displayErrorDetails"),
    $settings->get("errorMiddleware.logErrors"),
    $settings->get("errorMiddleware.logErrorDetails")));
