<?php

namespace Ksb\Validation\Message;

use Bootstrap\Interfaces\Helper\ValidateMessageInterface;

class PasswordMatchValidateMessage implements ValidateMessageInterface
{
    public static $fieldName = "Mật khẩu";

    /**
     * @inheritDoc
     *
     * @return void
     */
    public static function getMsg()
    {
        return static::$fieldName . " không chính xác";
    }

    /**
     * @inheritDoc
     *
     * @return void
     */
    public static function addCompare($prop)
    {
    }
}
