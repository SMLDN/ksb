<?php

namespace Ksb\Controller;

use Slim\Psr7\Request;
use Slim\Psr7\Response;

class HomeController extends BaseController
{

    public function index(Request $request, Response $response, $args): Response
    {
        return $this->view->render($response, "Home.twig");
    }
}
