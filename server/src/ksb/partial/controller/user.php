<?php

use Ksb\Controller\SheetController;
use Ksb\Controller\UserController;
use Ksb\Middleware\Route\AuthPermissionMiddleware;
use Ksb\Middleware\Route\GuestPermissionMiddleware;
use Slim\Routing\RouteCollectorProxy;

$app->group("/user", function (RouteCollectorProxy $group) {
    // active
    $group->get("/{userId:[0-9]+}/active/{activeToken:[a-zA-Z0-9]+}", UserController::class . ":activeGet")->setName("user.active")->add(GuestPermissionMiddleware::class);

    // create sheet
    $group->get("/sheet/create", SheetController::class . ":createGet")->setName("user.sheet.create")->add(AuthPermissionMiddleware::class);
    $group->post("/sheet/create", SheetController::class . ":createPost")->add(AuthPermissionMiddleware::class);
});
