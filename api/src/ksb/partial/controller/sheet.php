<?php

use Aloha\Utility\Str;
use Ksb\Controller\SheetController;
use Ksb\Middleware\Route\AuthPermissionMiddleware;
use Slim\Routing\RouteCollectorProxy;

$app->group("/sheet", function (RouteCollectorProxy $group) {
// Tạo sheet
    $group->post("/create", SheetController::class . ":createPost")->setName("sheet.create")->add(AuthPermissionMiddleware::class);
});

// Sheet view
$app->group("/user", function (RouteCollectorProxy $group) {
    $group->get("/{userId:[0-9]+}/sheet/{slug:" . Str::SLUG_PATTERN . "}", SheetController::class . ":viewGet")->setName("sheet.view");
});
