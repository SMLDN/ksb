<?php

namespace Aloha\Helper\Validation\Rule;

use Aloha\Interfaces\Helper\RuleInterface;

class EmailRule implements RuleInterface
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
        return filter_var($value, FILTER_VALIDATE_EMAIL) ? true : false;
    }
}
