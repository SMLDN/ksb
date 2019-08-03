<?php

namespace Bootstrap\Middleware;

use Bootstrap\Utility\Math;
use Bootstrap\Utility\Str;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CustomArgsMiddleware implements MiddlewareInterface
{
    /**
     * @inheritDoc
     *
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $route = $request->getAttribute("route");
        $args = $route->getArguments();
        foreach ($args as $arg => $value) {
            if (preg_match('/\A[a-z0-9]+(IdBased)\z/i', $arg) === 1) {
                $args[Str::replaceLast("Based", "", $arg)] = Math::toBase10($value);
            }
        }
        $route->setArguments($args);
        return $handler->handle($request);
    }
}
