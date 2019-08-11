<?php

namespace Aloha\Helper\Validation\Rule;

use Aloha\Interfaces\Helper\RuleInterface;
use Aloha\Utility\Str;

class MinLengthRule implements RuleInterface
{

    protected static $minValue;

    /**
     * Undocumented function
     *
     * @param [type] $field
     * @param [type] $value
     * @return void
     */
    public static function validate($field, $value = null)
    {
        return Str::length($value) >= static::$minValue;
    }

    /**
     * Undocumented function
     *
     * @param [type] $minValue
     * @return void
     */
    public static function addCompare($minValue)
    {
        static::$minValue = (int) $minValue;
    }
}
