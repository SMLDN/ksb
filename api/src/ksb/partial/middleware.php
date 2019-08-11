<?php

use Aloha\Middleware\CorsMiddleware;
use Aloha\Middleware\JsonBodyParserMiddleware;
use Ksb\Middleware\App\AuthMiddleware;
use Slim\Middleware\ErrorMiddleware;

// --App middleware-- //

// Auth
$app->add($container->newInstance(AuthMiddleware::class));

// Flash

// Routing Middleware
$app->addRoutingMiddleware();

// Json Parser
$app->add(new JsonBodyParserMiddleware);

// Error
$setting = $container->get("setting");
$errorMiddleware = new ErrorMiddleware($app->getCallableResolver(), $app->getResponseFactory(),
    $setting->get("errorMiddleware.displayErrorDetails"),
    $setting->get("errorMiddleware.logErrors"),
    $setting->get("errorMiddleware.logErrorDetails"));
$app->add($errorMiddleware);

// CORS
$app->add(new CorsMiddleware);
