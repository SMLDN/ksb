<?php

use Bootstrap\Middleware\CsrfMiddleware;
use Bootstrap\Middleware\CustomArgsMiddleware;
use Ksb\Handler\Errorhandler\HttpBadRequestHandler;
use Ksb\Middleware\App\AuthMiddleware;
use Ksb\Middleware\App\FlashMiddleware;
use Ksb\Middleware\App\TwigMiddleware;
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

// Twig
$app->add($container->newInstance(TwigMiddleware::class));

$app->add(new CustomArgsMiddleware);

$app->addRoutingMiddleware();

// Error
$setting = $container->get("setting");
$errorMiddleware = new ErrorMiddleware($app->getCallableResolver(), $app->getResponseFactory(),
    $setting->get("errorMiddleware.displayErrorDetails"),
    $setting->get("errorMiddleware.logErrors"),
    $setting->get("errorMiddleware.logErrorDetails"));
$errorMiddleware->setErrorHandler(HttpBadRequestException::class, $container->newInstance(HttpBadRequestHandler::class));
$app->add($errorMiddleware);
