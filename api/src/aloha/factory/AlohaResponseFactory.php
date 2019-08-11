<?php

namespace Aloha\Factory;

use Aloha\Helper\Response;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Interfaces\RouteParserInterface;

class AlohaResponseFactory implements ResponseFactoryInterface
{
    protected $router;

    /**
     * {@inheritdoc}
     */
    public function createResponse(
        int $code = StatusCodeInterface::STATUS_OK,
        string $reasonPhrase = ''
    ): ResponseInterface {
        $res = new Response($code, $this->router);
        if ($reasonPhrase !== '') {
            $res = $res->withStatus($code, $reasonPhrase);
        }

        return $res;
    }

    /**
     * setRouter
     *
     * @param [type] $router
     * @return void
     */
    public function setRouter(RouteParserInterface $router)
    {
        $this->router = $router;
    }
}
