<?php

use Ksb\Controller\Api\AuthController;
use Slim\Routing\RouteCollectorProxy;

$app->group("/api", function (RouteCollectorProxy $group) {
    //Login
    // $group->get("/login", AuthController::class . ":loginGet")->setName("auth.login")->add(GuestPermissionMiddleware::class);
    $group->post("/login", AuthController::class . ":loginPost")->setName("auth.login");

    //Logout
    $group->get("/logout", AuthController::class . ":logoutGet")->setName("auth.logout");

    // Register
    // $group->get("/register", AuthController::class . ":registerGet")->setName("auth.register")->add(GuestPermissionMiddleware::class);
    $group->post("/register", AuthController::class . ":registerPost");
});
