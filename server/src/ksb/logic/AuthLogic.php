<?php
namespace Ksb\Logic;

use Bootstrap\Helper\CookieManager;
use Bootstrap\Helper\SessionManager;
use Bootstrap\Utility\Time;
use Ksb\Model\User;

class AuthLogic
{
    protected $user;

    protected $cookieUserName = "keep_user";

    protected $cookieKeyName = "keep_key";

    protected $cookieValueName = "keep_value";

    protected $sessionUserName = "user_id";

    protected $sessionKeyName = "remember_key";

    protected $sessionValueName = "remember_value";

    protected $cookieLong = 180;

    /**
     * Tự động đăng nhập
     *
     * @return void
     */
    public function autoLogin()
    {
        if (!$this->loginFromSession()) {
            $this->loginFromCookie();
        }
    }

    /**
     * Đăng nhập dựa vào thông tin Session
     *
     * @return void
     */
    public function loginFromSession()
    {
        $sessionUserId = SessionManager::get($this->sessionUserName);
        $sessionKey = SessionManager::get($this->sessionKeyName);
        $sessionValue = SessionManager::get($this->sessionValueName);

        if (!$sessionUserId || !$sessionKey || !$sessionValue) {
            return false;
        }

        $cookieUserId = CookieManager::get($this->cookieUserName);
        $cookieKey = CookieManager::get($this->cookieKeyName);
        $cookieValue = CookieManager::get($this->cookieValueName);

        if ($sessionUserId != $cookieUserId || $sessionKey != $cookieKey || $sessionValue != $cookieValue) {
            return false;
        }

        $user = User::find($sessionUserId);

        if (!$user) {
            return false;
        }

        $this->user = $user;

        return true;
    }

    /**
     * Đăng nhập dựa vào thông tin cookie
     *
     * @return boolean
     */
    public function loginFromCookie()
    {
        $cookieUserId = CookieManager::get($this->cookieUserName);
        $cookieKey = CookieManager::get($this->cookieKeyName);
        $cookieValue = CookieManager::get($this->cookieValueName);

        if ($cookieUserId != null && $cookieKey != null && $cookieValue != null) {
            $user = User::find($cookieUserId);
            if ($user && $user->rememberKey == $cookieKey && $user->rememberValue == $cookieValue && $this->isCookieValid($user)) {
                $this->doLogin($user);
                return true;
            }
        }

        $this->unsetCookieLogin();
        return false;
    }

    /**
     * Cookie còn thời gian hiệu lực hay không?
     *
     * @return boolean
     */
    protected function isCookieValid(User $user)
    {
        $rememberLast = Time::parse($user->rememberLast)->timestamp;
        return Time::nowTimestamp() <= $rememberLast;
    }

    /**
     * Đăng nhập từ code
     *
     * @return void
     */
    public function loginFromProgram(User $user)
    {
        $this->doLogin($user);
    }

    /**
     * Đăng xuất
     *
     * @return void
     */
    public function logout()
    {
        $this->doLogout();
    }

    /**
     * Thêm thông tin đăng nhập vào cookie
     *
     * @return void
     */
    protected function setCookieLogin($userId, $rememberKey, $rememberValue, $time)
    {
        CookieManager::setTimeManually($this->cookieUserName, $userId, $time);
        CookieManager::setTimeManually($this->cookieKeyName, $rememberKey, $time);
        CookieManager::setTimeManually($this->cookieValueName, $rememberValue, $time);
    }

    /**
     * Xóa thông tin đăng nhập từ cookie
     *
     * @return void
     */
    protected function unsetCookieLogin()
    {
        CookieManager::unset($this->cookieUserName);
        CookieManager::unset($this->cookieKeyName);
        CookieManager::unset($this->cookieValueName);
    }

    /**
     * Thêm thông tin đăng nhập vào session
     *
     * @return void
     */
    protected function setSessionLogin($userId, $rememberKey, $rememberValue)
    {
        SessionManager::set($this->sessionUserName, $userId);
        SessionManager::set($this->sessionKeyName, $rememberKey);
        SessionManager::set($this->sessionValueName, $rememberValue);
    }

    /**
     * Đăng nhập
     *
     * @return void
     */
    protected function doLogin(User $user)
    {
        $cookieTime = Time::nowTimestamp() + ($this->cookieLong * 60);

        // update remember key & value
        $rememberKey = md5($user->email . Time::nowTimestamp());
        $rememberValue = hash("sha256", $user->email . Time::nowTimestamp() . uniqid("ksb-protected"));
        $user->rememberKey = $rememberKey;
        $user->rememberValue = $rememberValue;
        $user->rememberLast = Time::createFromTimestamp($cookieTime)->toDateTimeString();
        $user->update();
        $this->user = $user;

        // update cookie
        $this->setCookieLogin($user->id, $rememberKey, $rememberValue, $cookieTime);
        SessionManager::regenerate();
        $this->setSessionLogin($user->id, $rememberKey, $rememberValue);
    }

    /**
     * Đăng xuất
     *
     * @return void
     */
    protected function doLogout()
    {
        if (!$this->isLoggedIn()) {
            return;
        }

        $this->user = null;
        CookieManager::unset($this->cookieUserName);
        CookieManager::unset($this->cookieKeyName);
        CookieManager::unset($this->cookieValueName);
        SessionManager::regenerate();
    }

    /**
     * Get user
     *
     * @return void
     */
    public function getUser()
    {
        if ($this->user) {
            return $this->user->toArrayCamel();
        }

        return null;
    }

    /**
     * Get raw user
     *
     * @return void
     */
    public function getRawUser()
    {
        return $this->user;
    }

    /**
     * Người dùng hiện tại có đăng nhập hay không?
     *
     * @return boolean
     */
    public function isLoggedIn()
    {
        return isset($this->user) ? true : false;
    }

    /**
     * Người dùng chưa đăng nhập?
     *
     * @return boolean
     */
    public function isGuest()
    {
        return !isset($this->user) ? true : false;
    }

    /**
     * Lấy user id
     *
     * @return void
     */
    public function getUserId()
    {
        return $this->user ? $this->user->id : null;
    }
}
