<?php

namespace Bootstrap\Helper\Validation\Rule;

use Bootstrap\Interfaces\Helper\RuleInterface;

class PasswordRule implements RuleInterface
{
    /**
     * Validate
     *
     * @param [type] $field
     * @param [type] $value
     * @return void
     */
    public static function validate($field, $value = null)
    {
        // TODO trước mặt tạm thời cho phép đặt password đơn giản
        // return preg_match('/\A(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[a-zA-Z\d]{8,100}+\z/', $value) === 1;
        // _-=@$%&/\*
        return preg_match('/\A[a-zA-Z\d_\-=@\$%&\\/\\\*]{6,50}+\z/', $value) === 1;
    }
}
