<?php

namespace Aloha\Helper\Validation\Rule;

use Aloha\Interfaces\Helper\RuleInterface;
use Aloha\Utility\Str;

class MaxLengthRule implements RuleInterface
{

    protected static $maxValue;

    /**
     * Undocumented function
     *
     * @param [type] $field
     * @param [type] $value
     * @return void
     */
    public static function validate($field, $value = null)
    {
        return Str::length($value) <= static::$maxValue;
    }

    /**
     * Undocumented function
     *
     * @param [type] $maxValue
     * @return void
     */
    public static function addCompare($maxValue)
    {
        static::$maxValue = (int) $maxValue;
    }
}
