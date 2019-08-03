<?php

use Bootstrap\Utility\Str;
use Ksb\Controller\SheetAttachController;
use Slim\Routing\RouteCollectorProxy;

// --- Sheet Attach controller --- //

$app->group("/sheet-attach", function (RouteCollectorProxy $group) {
    $group->get("/{sheetAttachId:" . Str::UUID_PATTERN . "}", SheetAttachController::class . ":viewGet");
});
