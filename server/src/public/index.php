<?php

use Ksb\Config\RouteMiddlewareConfig;

require __DIR__ . "/../../vendor/autoload.php";

$partialDir = __DIR__ . "/../ksb/partial/";

// Init
require_once $partialDir . "init.php";

// App
require_once $partialDir . "app.php";

// Middleware
require_once $partialDir . "middleware.php";

// Controller
require_once $partialDir . "controller.php";

$app->run();
