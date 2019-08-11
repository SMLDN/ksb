<?php

namespace Ksb\Validation\Message;

use Aloha\Interfaces\Helper\ValidateMessageInterface;

class PasswordMatchValidateMessage implements ValidateMessageInterface
{
    public static $fieldName = "";

    /**
     * @inheritDoc
     *
     * @return void
     */
    public static function getMsg()
    {
        return "Thông tin đăng nhập không chính xác";
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
