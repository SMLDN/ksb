<?php

namespace Ksb\Validation\Rule;

use Bootstrap\Interfaces\Helper\RuleInterface;
use Illuminate\Support\Str;
use Ksb\Model\User;

class UserUniqueRule implements RuleInterface
{
    /**
     * Undocumented function
     *
     * @param [type] $field
     * @param [type] $value
     * @return void
     */
    public static function validate($field, $value = null)
    {
        if ($value == null) {
            return false;
        }
        return User::where(Str::snake($field), $value)->doesntExist();
    }
}
