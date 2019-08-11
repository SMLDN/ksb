<?php

namespace Aloha\Interfaces\Helper;

interface RuleInterface
{
    /**
     * Kiểm tra giá trị
     *
     * @param string $field
     * @param string $value
     * @return void
     */
    public static function validate(string $field, string $value = null);
}
