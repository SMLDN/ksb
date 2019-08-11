<?php

namespace Ksb\Validation\Message;

use Bootstrap\Interfaces\Helper\ValidateMessageInterface;

class UserExistValidateMessage implements ValidateMessageInterface
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
}
