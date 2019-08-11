<?php

use Ksb\Controller\Api\AuthController;
use Slim\Routing\RouteCollectorProxy;

$app->group("/api", function (RouteCollectorProxy $group) {
    // Login
    $group->post("/login", AuthController::class . ":loginPost")->setName("auth.login");
    // Logout
    $group->post("/logout", AuthController::class . ":logoutPost")->setName("auth.logout");
});
