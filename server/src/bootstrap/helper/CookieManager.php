<?php

namespace Bootstrap\Helper;

class CookieManager
{

    protected static $prefix = "ksb_";

    protected static $rememberUserName = "keep_user";

    protected static $rememberKeyName = "keep_key";

    protected static $rememberValueName = "keep_value";

    /**
     * Thêm cookie mới
     *
     * @param string $key
     * @param [type] $value
     * @param integer $time
     * @return void
     */
    public static function set(string $key, $value, int $time)
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
     * Thiết lập thông tin đăng nhập
     *
     * @param string $rememberKey
     * @param string $rememberValue
     * @param integer $time
     * @return void
     */
    public static function setLoginInfo(int $userId, string $rememberKey, string $rememberValue, int $time = 10)
    {
        static::set(static::$rememberUserName, $userId, $time);
        static::set(static::$rememberKeyName, $rememberKey, $time);
        static::set(static::$rememberValueName, $rememberValue, $time);
    }

    /**
     * Xóa thông tin đăng nhập
     *
     * @param string $rememberKey
     * @param string $rememberValue
     * @param integer $time
     * @return void
     */
    public static function unsetLoginInfo()
    {
        static::set(static::$rememberUserName, "", -1);
        static::set(static::$rememberKeyName, "", -1);
        static::set(static::$rememberValueName, "", -1);
    }

    /**
     * Lấy Remember key
     *
     * @return void
     */
    public static function getRememberKey()
    {
        return static::get(static::$rememberKeyName);
    }

    /**
     * Lấy Remember value
     *
     * @return void
     */
    public static function getRememberValue()
    {
        return static::get(static::$rememberValueName);
    }

    /**
     * Lấy Remember user
     *
     * @return void
     */
    public static function getRememberUser()
    {
        return static::get(static::$rememberUserName);
    }
}
