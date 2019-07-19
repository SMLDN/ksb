<?php

namespace Ksb\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class HomeController
{

    protected $view;

    /**
     * Construct
     *
     * @param Twig $view
     */
    public function __construct(Twig $view)
    {
        $this->view = $view;
    }

    /**
     * Trang chủ
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param [type] $args
     * @return void
     */
    public function home(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        return $this->view->render($response, "Home.twig");
    }
}
