<?php

namespace Bootstrap\Helper\Message;

use Bootstrap\Interfaces\Helper\ValidateMessageInterface;

class DefaultValidateMessage implements ValidateMessageInterface
{
    public static $fieldName = "Trường";

    public static function getMsg()
    {
        return static::$fieldName . " không hợp lệ";
    }
}
