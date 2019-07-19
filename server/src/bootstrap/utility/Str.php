<?php
namespace Bootstrap\Utility;

use Illuminate\Support\Str as IStr;

class Str extends IStr
{
    /**
     * Loại bỏ dấu cách dư thừa
     *
     * @param string $str
     * @return void
     */
    public static function trim(string $str)
    {
        return trim(preg_replace('/\s+/', ' ', $str));
    }
}
