<?php

namespace Bootstrap\Middleware;

use Bootstrap\Helper\SessionManager;
use Bootstrap\Utility\Str;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Psr7\Response;

class CsrfMiddleware implements MiddlewareInterface
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
        if ($request->getMethod() === "POST") {
            $csrfKey = $request->getParsedBody()["csrf_key"] ?? null;
            $csrfToken = $request->getParsedBody()["csrf_token"] ?? null;
            $sessionCsrfKey = SessionManager::get("csrf_key");
            $sessionCsrfToken = SessionManager::get("csrf_token");
            if (!Str::equal($csrfKey, $sessionCsrfKey) || !Str::equal($csrfToken, $sessionCsrfToken)) {
                throw new HttpBadRequestException($request);
            }
            SessionManager::reset("csrf_key");
            SessionManager::reset("csrf_token");
        }
        return $handler->handle($request);
    }
}
