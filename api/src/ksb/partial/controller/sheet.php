<?php

use Aloha\Utility\Str;
use Ksb\Controller\SheetController;
use Ksb\Middleware\Route\AuthPermissionMiddleware;
use Slim\Routing\RouteCollectorProxy;

$app->group("/sheet", function (RouteCollectorProxy $group) {
    // Tạo sheet
    $group->post("/create", SheetController::class . ":createPost")
        ->setName("sheet.create")
        ->add(AuthPermissionMiddleware::class);

    // Chỉnh sửa Sheet
    $group->put("/modify/{slug:" . Str::SLUG_PATTERN . "}", SheetController::class . ":modifyPut")
        ->setName("sheet.modify")
        ->add(AuthPermissionMiddleware::class);

    $group->get("/latest", SheetController::class . ":latestGet")
        ->setName("sheet.latest");
});

// Sheet view
$app->group("/user", function (RouteCollectorProxy $group) {
    $group->get("/{userId:[0-9]+}/sheet/{slug:" . Str::SLUG_PATTERN . "}", SheetController::class . ":viewGet")
        ->setName("sheet.view");
});
