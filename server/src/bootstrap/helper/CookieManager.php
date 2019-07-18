<?php

namespace Bootstrap\Helper;

class CookieManager
{

    protected static $prefix = "ksb_";

    /**
     * Thêm cookie mới
     *
     * @param string $key
     * @param [type] $value
     * @param integer $time
     * @return void
     */
    public static function set(string $key, string $value, int $time)
    {
        $key = static::$prefix . $key;
        // TODO domain với secure
        setcookie($key, $value, time() + ($time * 60), "/");
    }

    /**
     * Lấy giá trị từ cookie
     *
     * @param string $key
     * @return void
     */
    public static function get(string $key)
    {
        $key = static::$prefix . $key;
        if (empty($key)) {
            return null;
        }
        return $_COOKIE[$key] ?? null;
    }

    /**
     * Undocumented function
     *
     * @param string $key
     * @return void
     */
    function unset(string $key) {
        static::set($key, "", -1);
    }

}
