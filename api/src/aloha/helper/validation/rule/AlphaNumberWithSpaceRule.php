<?php

namespace Aloha\Helper\Validation\Rule;

use Aloha\Interfaces\Helper\RuleInterface;

class AlphaNumberWithSpaceRule implements RuleInterface
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
        return preg_match('/\A[a-z\s\d]*\z/i', $value) === 1;
    }
}
