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

    /**
     * Check 2 chuỗi có giống nhau không
     *  Nếu cùng null thì trả về false
     *
     * @return void
     */
    public static function equal($str1, $str2)
    {
        if ($str1 == null && $str2 == null) {
            return false;
        }
        return $str1 == $str2;
    }

    /**
     * Tạo slug string
     *
     * @return void
     */
    public static function makeSlugStr(string $slug)
    {
        return Str::slug($slug) . "-" . Time::nowToString() . random_int(10000, 99999);
    }
}
