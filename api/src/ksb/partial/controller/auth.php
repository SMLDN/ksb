<?php

use Ksb\Controller\AuthController;
use Slim\Routing\RouteCollectorProxy;

$app->group("/auth", function (RouteCollectorProxy $group) {
// Login
    $group->post("/login", AuthController::class . ":loginPost")->setName("auth.login");

// Logout
    $group->post("/logout", AuthController::class . ":logoutPost")->setName("auth.logout");

    // Register
    $group->post("/register", AuthController::class . ":registerPost")->setName("auth.register");
});
