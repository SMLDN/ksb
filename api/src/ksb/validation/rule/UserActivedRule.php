<?php

namespace Ksb\Validation\Rule;

use Aloha\Interfaces\Helper\RuleInterface;
use Aloha\Utility\Str;
use Ksb\Model\User;

class UserActivedRule implements RuleInterface
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

        return User::where(Str::snake($field), $value)->where("active_status", "1")->exists();
    }
}
