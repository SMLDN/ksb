<?php
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Factory\AppFactory;
use Aura\Di\ContainerBuilder;
use Slim\Middleware\ErrorMiddleware;

require __DIR__ . '/../../vendor/autoload.php';

$builder = new ContainerBuilder();
$container = $builder->newInstance();

// $container->set("viewer", $container->lazyNew("Congaco"));

AppFactory::setContainer($container);
$app = AppFactory::create();

$errorMiddleware = new ErrorMiddleware($app->getCallableResolver(), $app->getResponseFactory(), true, false, false);
$app->add($errorMiddleware);

$app->get("/", function (Request $request, Response $response, $args) {
    $response->getBody()->write("hello");
    return $response;
});

$app->run();
