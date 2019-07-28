<?php

use Ksb\Controller\SheetController;
use Ksb\Controller\UserController;
use Ksb\Middleware\Route\AuthPermissionMiddleware;
use Ksb\Middleware\Route\GuestPermissionMiddleware;
use Slim\Routing\RouteCollectorProxy;

// --- User controller --- //

// Tài khoản người dùng hiện tại
$app->group("/me", function (RouteCollectorProxy $group) {
    $group->get("", UserController::class . ":me")->setName("me.home");
    $group->group("/sheet", function (RouteCollectorProxy $childGroup) {
        // create sheet
        $childGroup->get("/create", SheetController::class . ":createGet")->setName("me.sheet.create");
        $childGroup->post("/create", SheetController::class . ":createPost");
        // edit sheet
        $childGroup->get("/edit/{slug:[a-zA-Z0-9\-]+}", SheetController::class . ":editGet")->setName("me.sheet.edit");
        $childGroup->post("/edit/{slug:[a-zA-Z0-9\-]+}", SheetController::class . ":editPost");
    });
})->add(AuthPermissionMiddleware::class);

// Tài khoản khác
$app->group("/user", function (RouteCollectorProxy $group) {
    $group->group("/{userId:[0-9]+}", function (RouteCollectorProxy $childGroup) {
        $childGroup->get("", UserController::class . ":home")->setName("user.home");
        $childGroup->get("/active/{activeToken:[a-zA-Z0-9]+}", UserController::class . ":activeGet")->setName("user.active")->add(GuestPermissionMiddleware::class);
        $childGroup->get("/sheet/{slug:[a-zA-Z0-9\-]+}", SheetController::class . ":viewGet")->setName("user.sheet.view");
    });
});
