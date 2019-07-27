<?php

use Bootstrap\Middleware\CsrfMiddleware;
use Ksb\Handler\Errorhandler\HttpBadRequestHandler;
use Ksb\Middleware\App\AuthMiddleware;
use Ksb\Middleware\App\FlashMiddleware;
use Slim\Exception\HttpBadRequestException;
use Slim\Middleware\ErrorMiddleware;

// --App middleware-- //

// Auth
$app->add($container->newInstance(AuthMiddleware::class));

// Flash
$app->add($container->newInstance(FlashMiddleware::class));

// Csrf
if (!getenv("DEBUG")) {
    $app->add(new CsrfMiddleware);
}

// Error
$setting = $container->get("setting");
$errorMiddleware = new ErrorMiddleware($app->getCallableResolver(), $app->getResponseFactory(),
    $setting->get("errorMiddleware.displayErrorDetails"),
    $setting->get("errorMiddleware.logErrors"),
    $setting->get("errorMiddleware.logErrorDetails"));
$errorMiddleware->setErrorHandler(HttpBadRequestException::class, $container->newInstance(HttpBadRequestHandler::class));
$app->add($errorMiddleware);
