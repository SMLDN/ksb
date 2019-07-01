<?php

use Ksb\Controller\HomeController;

$app->get("/", HomeController::class . ":index");
