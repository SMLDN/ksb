<?php

use Ksb\Controller\AuthController;
use Ksb\Middleware\Route\AuthPermissionMiddleware;
use Ksb\Middleware\Route\GuestPermissionMiddleware;
use Slim\Routing\RouteCollectorProxy;

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
