<?php

use Ksb\Controller\UserController;
use Ksb\Middleware\Route\AuthPermissionMiddleware;
use Slim\Routing\RouteCollectorProxy;

// --- User controller --- //

$app->group("/user", function (RouteCollectorProxy $group) {
    // Tài khoản người dùng hiện tại
    // Me
    $group->get("/me", UserController::class . ":me")->setName("user.me")->add(AuthPermissionMiddleware::class);

    // Tài khoản khác
    // Activative
    $group->get("/{userId:[0-9]+}/active/{activeToken:[a-z0-9]+}", UserController::class . ":activeGet")->setName("user.active");
});
