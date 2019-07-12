<?php

namespace Ksb\Validation\Message;

use Bootstrap\Interfaces\Helper\ValidateMessageInterface;

class UserUniqValidValidateMessage implements ValidateMessageInterface
{
    public static $fieldName = "Trường";

    public static function getMsg()
    {
        return static::$fieldName . " không hợp lệ";
    }
}
