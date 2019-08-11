<?php

namespace Aloha\Helper\Validation\Message;

use Aloha\Interfaces\Helper\ValidateMessageInterface;

class MinLengthValidateMessage implements ValidateMessageInterface
{
    public static $fieldName = "Trường";

    protected static $minValue;

    /**
     * Undocumented function
     *
     * @return void
     */
    public static function getMsg()
    {
        return static::$fieldName . " yêu cầu nhập tối thiểu " . static::$minValue . " ký tự";
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public static function addCompare($minValue)
    {
        static::$minValue = (int) $minValue;
    }
}
