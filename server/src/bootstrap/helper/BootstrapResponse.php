<?php

namespace Bootstrap\Helper;

use Fig\Http\Message\StatusCodeInterface;
use Slim\Interfaces\RouteParserInterface;
use Slim\Psr7\Response;

class BootstrapResponse extends Response
{
    protected $router;

    /**
     * Redirect về 1 trang chỉ định
     *
     * @param [type] $url
     * @param [type] $status
     * @return void
     */
    public function withRedirect($url, $status = null)
    {
        $responseWithRedirect = $this->withHeader('Location', (string) $url);
        if (is_null($status) && $this->getStatusCode() === StatusCodeInterface::STATUS_OK) {
            $status = StatusCodeInterface::STATUS_FOUND;
        }
        if (!is_null($status)) {
            return $responseWithRedirect->withStatus($status);
        }
        return $responseWithRedirect;
    }

    /**
     * Redirect đến địa chỉ dựa theo route
     *
     * @return void
     */
    public function redirectTo($routeName, $status = null)
    {
        return $this->withRedirect($this->router->urlFor($routeName), $status);
    }

    /**
     * setRouter
     *
     * @param RouteParserInterface $router
     * @return void
     */
    public function setRouter(RouteParserInterface $router)
    {
        $this->router = $router;
    }

    /**
     * getRouter
     *
     * @return void
     */
    public function getRouter()
    {
        return $this->router;
    }
}
