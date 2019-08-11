<?php

namespace Ksb\Validation\Message;

use Aloha\Interfaces\Helper\ValidateMessageInterface;

class UserActivedValidateMessage implements ValidateMessageInterface
{
    public static $fieldName = "";

    /**
     * @inheritDoc
     *
     * @return void
     */
    public static function getMsg()
    {
        return "Tài khoản không tồn tại hoặc chưa được kích hoạt";
    }
}
