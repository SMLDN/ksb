<?php

namespace Ksb\Validation\Rule;

use Bootstrap\Interfaces\Helper\RuleInterface;
use Bootstrap\Utility\Str;
use Ksb\Model\User;

class UserExistRule implements RuleInterface
{
    /**
     * @inheritDoc
     *
     * @param [type] $field
     * @param [type] $value
     * @return void
     */
    public static function validate($field, $value = null)
    {
        if (empty($value)) {
            return false;
        }
        return User::where(Str::snake($field), $value)->exists();
    }
}
