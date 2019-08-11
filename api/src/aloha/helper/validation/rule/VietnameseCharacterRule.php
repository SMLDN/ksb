<?php

namespace Aloha\Helper\Validation\Rule;

use Aloha\Config\VietnameseCharacterUnicode;
use Aloha\Interfaces\Helper\RuleInterface;

class VietnameseCharacterRule implements RuleInterface
{
    /**
     * a-Z, số, ký tự tiếng Việt và dấu cách
     *
     * @param [type] $field
     * @param [type] $value
     * @return void
     */
    public static function validate($field, $value = null)
    {
        $unicodeList = VietnameseCharacterUnicode::getUnicode();
        $unicodeStr = implode("", $unicodeList);
        $pattern = '/\A[a-zA-Z\s\d' . $unicodeStr . ']*\z/u';

        return preg_match($pattern, $value) === 1;
    }
}
