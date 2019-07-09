<?php

namespace Bootstrap\Factory;

use Bootstrap\Helper\BootstrapResponse;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;

class BootstrapResponseFactory implements ResponseFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createResponse(
        int $code = StatusCodeInterface::STATUS_OK,
        string $reasonPhrase = ''
    ): ResponseInterface {
        $res = new BootstrapResponse($code);

        if ($reasonPhrase !== '') {
            $res = $res->withStatus($code, $reasonPhrase);
        }

        return $res;
    }
}
