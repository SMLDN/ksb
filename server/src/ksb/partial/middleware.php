<?php

use Bootstrap\Middleware\CsrfMiddleware;
use Ksb\Handler\Errorhandler\HttpBadRequestHandler;
use Ksb\Middleware\AuthMiddleware;
use Ksb\Middleware\FlashMiddleware;
use Slim\Exception\HttpBadRequestException;
use Slim\Middleware\ErrorMiddleware;

$setting = $container->get("setting");

// if (!getenv("DEBUG")) {
$app->add(new CsrfMiddleware);
// }

$app->add($container->newInstance(AuthMiddleware::class));

$app->add($container->newInstance(FlashMiddleware::class));

$errorMiddleware = new ErrorMiddleware($app->getCallableResolver(), $app->getResponseFactory(),
    $setting->get("errorMiddleware.displayErrorDetails"),
    $setting->get("errorMiddleware.logErrors"),
    $setting->get("errorMiddleware.logErrorDetails"));

$errorMiddleware->setErrorHandler(HttpBadRequestException::class, HttpBadRequestHandler::class);
$app->add($errorMiddleware);
