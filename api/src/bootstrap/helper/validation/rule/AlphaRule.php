<?php

namespace Bootstrap\Helper\Validation\Rule;

use Bootstrap\Interfaces\Helper\RuleInterface;

class AlphaRule implements RuleInterface
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
        return preg_match('/\A[a-z]*\z/i', $value) === 1;
    }
}
