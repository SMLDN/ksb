<?php

use Slim\Middleware\ErrorMiddleware;

$app->add(new ErrorMiddleware($app->getCallableResolver(), $app->getResponseFactory(), true, true, true));
