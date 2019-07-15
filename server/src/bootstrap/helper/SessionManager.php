<?php

namespace Bootstrap\Helper;

use Illuminate\Support\Str;
use Slim\Views\Twig;

class SessionManager
{
    protected static $started = false;

    /**
     * Start session
     *
     * @return void
     */
    public static function start()
    {
        if (!self::$started) {
            session_start();
            self::$started = true;
        }
    }

    /**
     * Làm mới session id
     *
     * @return void
     */
    public static function regenerate()
    {
        if (self::$started) {
            session_regenerate_id();
        }
    }

    /**
     * Lấy giá trị
     *
     * @param string $key
     * @return void
     */
    public static function get(string $key)
    {
        if (empty($key)) {
            return null;
        }
        return $_SESSION[$key] ?? null;
    }

    /**
     * Thiết lập giá trị
     *
     * @param string $key
     * @param [type] $value
     * @return void
     */
    public static function set(string $key, $value)
    {
        if (empty($value)) {
            return;
        }
        $_SESSION[$key] = $value;
    }

    /**
     * Thiết lập giá trị tạm thời
     *
     * @param Twig $view
     * @param [type] $key
     * @return void
     */
    public static function setFlash(Twig $view, string $key)
    {
        if (self::get($key) != null && $view) {
            $view->getEnvironment()->addGlobal(Str::camel($key), self::get($key));
            self::reset($key);
        }
    }

    /**
     * Xóa giá trị
     *
     * @param string $key
     * @return void
     */
    public static function reset(string $key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }
}
