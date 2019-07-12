<?php

namespace Bootstrap\Interfaces\Helper;

interface RuleInterface
{
    public static function validate(string $field, string $value = null);
}
