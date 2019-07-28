<?php

use Ksb\Controller\SheetController;
use Ksb\Controller\UserController;
use Ksb\Middleware\Route\AuthPermissionMiddleware;
use Ksb\Middleware\Route\GuestPermissionMiddleware;
use Slim\Routing\RouteCollectorProxy;

$app->group("/user", function (RouteCollectorProxy $group) {
    $group->group("/{userId:[0-9]+}", function (RouteCollectorProxy $childGroup) {
        // active
        $childGroup->get("/active/{activeToken:[a-zA-Z0-9]+}", UserController::class . ":activeGet")->setName("user.active")->add(GuestPermissionMiddleware::class);
        $childGroup->get("/sheet/{slug:[a-zA-Z0-9\-]+}", SheetController::class . ":viewGet")->setName("user.sheet.view");
    });

    $group->group("/sheet", function (RouteCollectorProxy $childGroup) {
        // create sheet
        $childGroup->get("/create", SheetController::class . ":createGet")->setName("user.sheet.create")->add(AuthPermissionMiddleware::class);
        $childGroup->post("/create", SheetController::class . ":createPost")->add(AuthPermissionMiddleware::class);
        // edit sheet
        $childGroup->get("/edit/{slug:[a-zA-Z0-9\-]+}", SheetController::class . ":editGet")->setName("user.sheet.edit")->add(AuthPermissionMiddleware::class);
        $childGroup->post("/edit/{slug:[a-zA-Z0-9\-]+}", SheetController::class . ":editPost")->add(AuthPermissionMiddleware::class);
    });
});
