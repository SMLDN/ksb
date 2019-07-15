<?php

namespace Ksb\Validation\Message;

use Bootstrap\Interfaces\Helper\ValidateMessageInterface;

class UserUniqueValidateMessage implements ValidateMessageInterface
{
    public static $fieldName = "Trường";

    public static function getMsg()
    {
        return static::$fieldName . " đã tồn tại";
    }
}
