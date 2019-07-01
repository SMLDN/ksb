<?php

use Slim\Views\Twig;
use Ksb\Controller\BaseController;
use Ksb\Controller\HomeController;

$container->set("view", function () {
    $view = new Twig(__DIR__ . "/../view");
    return $view;
});

$container->params[BaseController::class]["view"] = $container->lazyGet("view");
$container->set(HomeController::class, $container->lazyNew(HomeController::class));
