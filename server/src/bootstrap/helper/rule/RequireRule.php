<?php

namespace Bootstrap\Helper\Rule;

use Bootstrap\Interfaces\Helper\RuleInterface;

class RequireRule implements RuleInterface
{
    /**
     * Undocumented function
     *
     * @param [type] $field
     * @param [type] $value
     * @return void
     */
    public static function validate(string $field, $value = null)
    {
        return !empty($value);
    }
}
