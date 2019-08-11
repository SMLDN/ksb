<?php

namespace Aloha\Helper\Validation\Message;

use Aloha\Interfaces\Helper\ValidateMessageInterface;

class MaxLengthValidateMessage implements ValidateMessageInterface
{
    public static $fieldName = "Trường";

    protected static $maxValue;

    /**
     * Undocumented function
     *
     * @return void
     */
    public static function getMsg()
    {
        return static::$fieldName . " yêu cầu nhập tối đa " . static::$maxValue . " ký tự";
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public static function addCompare($maxValue)
    {
        static::$maxValue = (int) $maxValue;
    }
}
