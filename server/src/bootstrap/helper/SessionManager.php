<?php

namespace Bootstrap\Helper;

use Illuminate\Support\Str;
use Slim\Views\Twig;

class SessionManager
{

    protected static $sessionValidTime = 180;

    /**
     * Start session
     *
     * @return void
     */
    public static function start()
    {
        ini_set('session.use_strict_mode', 1);
        session_start();
        // Do not allow to use too old session ID
        if (!static::checkSessionValid()) {
            session_destroy();
            session_start();
        }
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public static function checkSessionValid()
    {
        return empty($_SESSION["deleted_time"]) || $_SESSION["deleted_time"] > time()-static::$sessionValidTime;
    }

    /**
     * Làm mới session id
     *
     * @return void
     */
    public static function regenerate()
    {
        // Call session_create_id() while session is active to
        // make sure collision free.
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
        // WARNING: Never use confidential strings for prefix!
        $newid = session_create_id("ksb-");
        // Set deleted timestamp. Session data must not be deleted immediately for reasons.
        $_SESSION["deleted_time"] = time();
        // Finish session
        session_commit();
        // Make sure to accept user defined session ID
        // NOTE: You must enable use_strict_mode for normal operations.
        ini_set("session.use_strict_mode", 0);
        // Set new custom session ID
        session_id($newid);
        // Start with custom session ID
        session_start();
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
