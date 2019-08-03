<?php

use Ksb\Controller\HomeController;

// --Controller-- //

// home
$app->get("/", HomeController::class . ":home")->setName("home");

$partialDir = __DIR__ . "//controller/";

// auth
require_once $partialDir . "auth.php";

// user
require_once $partialDir . "user.php";

//sheet attach
require_once $partialDir . "sheetattach.php";
