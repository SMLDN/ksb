<?php

namespace Aloha\Helper\Validation\Message;

use Aloha\Interfaces\Helper\ValidateMessageInterface;

class DefaultValidateMessage implements ValidateMessageInterface
{
    public static $fieldName = "Trường";

    public static function getMsg()
    {
        return static::$fieldName . " không hợp lệ";
    }
}
