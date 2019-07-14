<?php

namespace Bootstrap\Helper\Validation\Message;

use Bootstrap\Interfaces\Helper\ValidateMessageInterface;

class PasswordValidateMessage implements ValidateMessageInterface
{
    public static $fieldName = "Trường";

    public static function getMsg()
    {
        return static::$fieldName . " chứa ký tự không hợp lệ";
    }
}
