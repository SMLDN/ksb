<?php

namespace Bootstrap\Middleware;

use Ksb\Logic\AuthLogic;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Views\Twig;

class AuthMiddleware implements MiddlewareInterface
{
    protected $authLogic;
    protected $view;

    /**
     * Construct
     *
     * @param AuthLogic $authLogic
     */
    public function __construct(Twig $view, AuthLogic $authLogic)
    {
        $this->view = $view;
        $this->authLogic = $authLogic;
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
        $this->authLogic->autoLogin();
        $this->view->getEnvironment()->addGlobal("user", $this->authLogic->getUser());
        return $handler->handle($request);
    }
}
