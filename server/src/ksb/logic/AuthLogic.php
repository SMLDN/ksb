<?php
namespace Ksb\Logic;

use Bootstrap\Helper\CookieManager;
use Ksb\Model\User;

class AuthLogic
{
    protected $user;

    protected $userLogic;

    /**
     * Construct
     */
    public function __construct(UserLogic $userLogic)
    {
        $this->userLogic = $userLogic;
        $this->loginFromCookie();
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
     * Đăng nhập dựa theo thông tin cookie
     *
     * @return boolean
     */
    public function loginFromCookie()
    {
        $userId = CookieManager::getRememberUser();
        $cookieKey = CookieManager::getRememberKey();
        $cookieValue = CookieManager::getRememberValue();
        if ($userId != null && $cookieKey != null && $cookieValue != null) {
            $user = User::find($userId);
            if ($user && $user->rememberKey == $cookieKey && $user->rememberValue == $cookieValue) {
                $this->userLogic->doLogin($user);
                $this->user = $user;
                return true;
            }
        }
        CookieManager::unsetLoginInfo();
        return false;
    }
}
