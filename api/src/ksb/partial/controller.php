<?php

use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

// --Controller-- //

$app->options("/[{path:.*}]", function (ServerRequestInterface $request, ResponseInterface $response) {
    return $response->withStatus(StatusCodeInterface::STATUS_OK);
});

$partialDir = __DIR__ . "//controller/";

// auth
require_once $partialDir . "auth.php";

// user
require_once $partialDir . "user.php";

//sheet
require_once $partialDir . "sheet.php";

//sheet attach
require_once $partialDir . "sheetattach.php";
