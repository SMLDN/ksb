<?php

namespace Aloha\Utility;

use Psr\Http\Message\UploadedFileInterface;
use Slim\Psr7\Stream;

class Upload
{
    /**
     * Encode
     *
     * @param UploadedFileInterface $file
     * @return void
     */
    public static function encode(UploadedFileInterface $file)
    {
        return base64_encode($file->getStream()->getContents());
    }

    /**
     * Decode to stream
     *
     * @param [type] $resource
     * @return void
     */
    public function decodeToStream($resource)
    {
        $stream = new Stream($resource);
        return base64_decode($stream->getContents());
    }
}
