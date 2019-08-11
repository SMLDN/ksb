<?php

namespace Ksb\Middleware\App;

use Aloha\Helper\Response;
use Exception;
use Fig\Http\Message\StatusCodeInterface;
use Ksb\Logic\AuthLogic;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthMiddleware implements MiddlewareInterface
{
    protected $authLogic;

    /**
     * Construct
     *
     * @param AuthLogic $authLogic
     */
    public function __construct(AuthLogic $authLogic)
    {
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
        try {
            $this->authLogic->loginByHeader($request);
        } catch (Exception $e) {
            $response = new Response;
            return $response->withStatus(StatusCodeInterface::STATUS_UNAUTHORIZED);
        }
        return $handler->handle($request);
    }
}
