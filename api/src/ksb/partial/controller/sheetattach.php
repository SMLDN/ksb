<?php

use Aloha\Utility\Str;
use Ksb\Controller\SheetAttachController;
use Ksb\Middleware\Route\AuthPermissionMiddleware;
use Slim\Routing\RouteCollectorProxy;

// --- Sheet Attach controller --- //
$app->group("/sheet-attach", function (RouteCollectorProxy $group) {
    // Upload Attach
    $group->post("/create", SheetAttachController::class . ":createPost")
        ->setName("sheet-attach.create")
        ->add(AuthPermissionMiddleware::class);
    // View Attach
    $group->get("/get/{sheetAttachId:" . Str::UUID_PATTERN . "}", SheetAttachController::class . ":viewGet")
        ->setName("sheet-attach.get");
});
