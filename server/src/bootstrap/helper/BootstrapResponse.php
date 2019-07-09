<?php

namespace Bootstrap\Helper;

use Fig\Http\Message\StatusCodeInterface;
use Slim\Psr7\Response;

class BootstrapResponse extends Response
{
    /**
     * TODO xài tạm đợi bên Slim4 được thực thi
     * Trả response với status chỉ định trước
     *
     * @param [type] $code
     * @param string $reasonPhrase
     * @return void
     */
    public function withStatus($code, $reasonPhrase = '')
    {
        $code = $this->filterStatus($code);
        if (!is_string($reasonPhrase) && !method_exists($reasonPhrase, '__toString')) {
            throw new InvalidArgumentException('ReasonPhrase must be a string');
        }
        $clone = clone $this;
        $clone->status = $code;
        if ($reasonPhrase === '' && isset(static::$messages[$code])) {
            $reasonPhrase = static::$messages[$code];
        }
        if ($reasonPhrase === '') {
            throw new InvalidArgumentException('ReasonPhrase must be supplied for this code');
        }
        $clone->reasonPhrase = $reasonPhrase;
        return $clone;
    }

    /**
     * TODO xài tạm đợi bên Slim4 được thực thi
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
}
