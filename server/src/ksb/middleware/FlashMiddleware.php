<?php

namespace Ksb\Middleware;

use Ksb\Helper\Flash;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class FlashMiddleware implements MiddlewareInterface
{
    protected $flash;

    /**
     * Construct
     *
     * @param Flash $flash
     */
    public function __construct(Flash $flash)
    {
        $this->flash = $flash;
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
        $this->flash->setGlobalFlash();
        return $handler->handle($request);
    }
}
