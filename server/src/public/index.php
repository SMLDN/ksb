<?php

use Slim\Views\Twig;
use Slim\Factory\AppFactory;
use Aura\Di\ContainerBuilder;

require __DIR__ . "/../../vendor/autoload.php";

session_start();

$builder = new ContainerBuilder();
$container = $builder->newInstance($builder::AUTO_RESOLVE);

//Config container
require_once __DIR__ . "/../bootstrap/container.php";

AppFactory::setContainer($container);
$app = AppFactory::create();

//Config app middleware
require_once __DIR__ . "/../bootstrap/middleware.php";

// Config controller
require_once __DIR__ . "/../bootstrap/controller.php";

$app->run();
