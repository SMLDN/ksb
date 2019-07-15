<?php

namespace Ksb\Validation\Message;

use Bootstrap\Interfaces\Helper\ValidateMessageInterface;

class UserExistValidateMessage implements ValidateMessageInterface
{
    public static $fieldName = "Tài khoản";

    /**
     * @inheritDoc
     *
     * @return void
     */
    public static function getMsg()
    {
        return static::$fieldName . " không tồn tại";
    }
}
