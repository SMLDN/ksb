<?php

use Ksb\Controller\AuthController;
use Ksb\Controller\HomeController;

$app->get("/", HomeController::class . ":index")->setName("index");

//login
$app->get("/auth/login", AuthController::class . ":loginGet")->setName("auth.login");
$app->post("/auth/login", AuthController::class . ":loginPost");

//logout
$app->get("/auth/logout", AuthController::class . ":logoutGet")->setName("auth.logout");

//regsiter
$app->get("/auth/register", AuthController::class . ":registerGet")->setName("auth.register");
$app->post("/auth/register", AuthController::class . ":registerPost");
