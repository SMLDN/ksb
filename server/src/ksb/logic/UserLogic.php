<?php

namespace Ksb\Logic;

use Bootstrap\Helper\CookieManager;
use Bootstrap\Helper\Validation\BootstrapValidator;
use Ksb\Model\User;
use Ksb\Validation\Rule\PasswordMatchRule;
use Ksb\Validation\Rule\UserExistRule;
use Ksb\Validation\Rule\UserUniqueRule;

class UserLogic
{

    /**
     * Login User(có kèm check password)
     *
     * @param User $user
     * @return void
     */
    public function login(User $user)
    {
        $v = new BootstrapValidator();
        $v->setData($user->getAttributesCamel());

        // Email
        $v->addRule("email",
            [
                "fieldName" => "Email",
                "rule" => [
                    "require",
                    "email",
                    "minLength:6",
                    "maxLength:100",
                    "userExist",
                ],
            ]
        );

        // Mật khẩu
        $v->addRule("password",
            [
                "fieldName" => "Mật khẩu",
                "rule" => [
                    "require",
                    "password",
                    "passwordMatch:" . $user->email,
                ],
            ]
        );

        $v->addClassPath(UserExistRule::class);
        $v->addClassPath(PasswordMatchRule::class);

        if ($v->isPassed()) {
            $user = User::where("email", $user->email)->first();
            $this->doLogin($user);
            return true;
        }

        $user->setValidationErrors($v->getErrors());
        return false;
    }

    /**
     * Đăng ký user mới
     *
     * @param User $user
     * @return void
     */
    public function register(User $user)
    {
        $user->userName = trim(preg_replace('/\s+/', ' ', $user->userName));

        $v = new BootstrapValidator();
        $v->setData($user->getAttributesCamel());
        // Tên hiển thị
        $v->addRule("userName",
            [
                "fieldName" => "Tên hiển thị",
                "rule" => [
                    "require",
                    "vietnameseCharacter",
                    "minLength:6",
                    "maxLength:50",
                    "userUnique",
                ],
            ]
        );

        // Email
        $v->addRule("email",
            [
                "fieldName" => "Email",
                "rule" => [
                    "require",
                    "email",
                    "minLength:6",
                    "maxLength:100",
                    "userUnique",
                ],
            ]
        );

        // Mật khẩu
        $v->addRule("password",
            [
                "fieldName" => "Mật khẩu",
                "rule" => [
                    "require",
                    "password",
                    "minLength:6",
                    "maxLength:100",
                ],
            ]
        );

        $v->addClassPath(UserUniqueRule::class);

        if ($v->isPassed()) {
            $this->doRegister($user);
        } else {
            $user->setValidationErrors($v->getErrors());
        }

        return $user;
    }

    /**
     * Undocumented function
     *
     * @param User $user
     * @return void
     */
    public function doRegister(User $user)
    {
        $user->password = password_hash($user->password, PASSWORD_ARGON2I);
        $user->active_status = "0";
        $user->save();
    }

    /**
     * Đăng nhập user
     *
     * @return void
     */
    public function doLogin(User $user)
    {
        CookieManager::unsetLoginInfo();
        $rememberKey = md5($user->email . time());
        $rememberValue = hash("sha256", $user->email . time() . uniqid("ksb"));
        $user->rememberKey = $rememberKey;
        $user->rememberValue = $rememberValue;
        $user->update();
        CookieManager::setLoginInfo($user->userId, $rememberKey, $rememberValue);

    }

    /**
     * Đăng xuất
     *
     * @return void
     */
    public function doLogout()
    {
        CookieManager::unsetLoginInfo();
    }
}
