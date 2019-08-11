<?php

use Ksb\Controller\Api\UserController;
use Ksb\Middleware\Route\AuthPermissionMiddleware;
use Slim\Routing\RouteCollectorProxy;

// --- User controller --- //

// Tài khoản người dùng hiện tại
$app->group("/api/me", function (RouteCollectorProxy $group) {
    $group->get("", UserController::class . ":me")->setName("me.home")->add(AuthPermissionMiddleware::class);
});

// Tài khoản khác
