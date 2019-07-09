<?php

use Ksb\Controller\AuthController;
use Ksb\Controller\HomeController;

$app->get("/", HomeController::class . ":index")->setName("index");

$app->get("/auth/login", AuthController::class . ":loginGet")->setName("auth.login");

$app->post("/auth/login", AuthController::class . ":loginPost");
