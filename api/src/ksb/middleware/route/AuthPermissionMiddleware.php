<?php

namespace Ksb\Middleware\Route;

use Aloha\Helper\Response;
use Fig\Http\Message\StatusCodeInterface;
use Ksb\Logic\AuthLogic;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Routing\RouteParser;

class AuthPermissionMiddleware implements MiddlewareInterface
{
    protected $authLogic;
    protected $router;

    /**
     * Construct
     *
     * @param AuthLogic $authLogic
     */
    public function __construct(AuthLogic $authLogic, RouteParser $router)
    {
        $this->authLogic = $authLogic;
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
        if ($this->authLogic->isLoggedIn()) {
            return $handler->handle($request);
        }

        $response = new Response;
        return $response->withStatus(StatusCodeInterface::STATUS_UNAUTHORIZED);
    }
}
