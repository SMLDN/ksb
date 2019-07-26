<?php

use Ksb\Controller\AuthController;
use Ksb\Controller\HomeController;
use Ksb\Controller\SheetController;
use Ksb\Controller\UserController;
use Ksb\Middleware\Route\AuthPermissionMiddleware;
use Ksb\Middleware\Route\GuestPermissionMiddleware;
use Slim\Routing\RouteCollectorProxy;

// home
$app->get("/", HomeController::class . ":home")->setName("home");

// auth
$app->group("/auth", function (RouteCollectorProxy $group) {
    //Login
    $group->get("/login", AuthController::class . ":loginGet")->setName("auth.login")->add(GuestPermissionMiddleware::class);
    $group->post("/login", AuthController::class . ":loginPost")->add(GuestPermissionMiddleware::class);

    //Logout
    $group->get("/logout", AuthController::class . ":logoutGet")->setName("auth.logout")->add(AuthPermissionMiddleware::class);

    // Register
    $group->get("/register", AuthController::class . ":registerGet")->setName("auth.register")->add(GuestPermissionMiddleware::class);
    $group->post("/register", AuthController::class . ":registerPost")->add(GuestPermissionMiddleware::class);
});

// user
$app->group("/user", function (RouteCollectorProxy $group) {
    // active
    $group->get("/{userId:[0-9]+}/active/{activeToken:[a-zA-Z0-9]+}", UserController::class . ":activeGet")->setName("user.active")->add(GuestPermissionMiddleware::class);

    // create sheet
    $group->get("/sheet/create", SheetController::class . ":createGet")->setName("user.sheet.create")->add(AuthPermissionMiddleware::class);
    $group->post("/sheet/create", SheetController::class . ":createPost")->add(AuthPermissionMiddleware::class);
});
