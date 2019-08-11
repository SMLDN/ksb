<?php
namespace Aloha\Utility;

use Illuminate\Support\Str as IStr;

class Str extends IStr
{
    // UUID
    const UUID_PATTERN = "[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}";
    // Slug
    const SLUG_PATTERN = "[a-z0-9-]*-[0-9]{19}";

    /**
     * Loại bỏ dấu cách dư thừa
     *
     * @param string $str
     * @return void
     */
    public static function trim($str)
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

    /**
     * Tạo chuỗi ngẫu nhiên
     *
     * @param integer $length
     * @return void
     */
    public static function randomStr(int $length)
    {
        return substr(bin2hex(random_bytes($length)), 0, $length);
    }
}
