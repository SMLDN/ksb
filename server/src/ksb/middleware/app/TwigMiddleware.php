<?php

namespace Ksb\Middleware\App;

use Ksb\Helper\Extension\KsbTwigExtension;
use Ksb\Logic\AuthLogic;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Routing\RouteParser;
use Slim\Views\Twig;

class TwigMiddleware implements MiddlewareInterface
{
    protected $view;
    protected $router;

    /**
     * Construct
     *
     * @param AuthLogic $authLogic
     */
    public function __construct(Twig $view, RouteParser $router)
    {
        $this->view = $view;
        $this->router = $router;
    }

    /**
     * @inheritDoc
     *
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->view->addExtension(new KsbTwigExtension($this->router, $request->getUri()));
        return $handler->handle($request);
    }
}
