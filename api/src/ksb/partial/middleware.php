<?php

use Aloha\Middleware\CorsMiddleware;
use Ksb\Middleware\App\AuthMiddleware;
use Slim\Middleware\ErrorMiddleware;

// --App middleware-- //

// Auth
$app->add($container->newInstance(AuthMiddleware::class));

// Routing Middleware
$app->addRoutingMiddleware();

// Body Parsing Middleware Parser
$app->addBodyParsingMiddleware();

// Error
$setting = $container->get("setting");
$errorMiddleware = new ErrorMiddleware($app->getCallableResolver(), $app->getResponseFactory(),
    $setting->get("errorMiddleware.displayErrorDetails"),
    $setting->get("errorMiddleware.logErrors"),
    $setting->get("errorMiddleware.logErrorDetails"));
$app->add($errorMiddleware);

// CORS
$app->add(new CorsMiddleware);
