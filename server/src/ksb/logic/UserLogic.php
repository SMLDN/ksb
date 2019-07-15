<?php

namespace Ksb\Logic;

use Bootstrap\Helper\Validation\BootstrapValidator;
use Ksb\Model\User;
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
        $dbUser = User::where("login_name", $user->loginName)->first();

        if (!$dbUser) {
            return false;
        }

        if ($user->password != $dbUser->password) {
            return false;
        }

        return true;
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
            $user->password = password_hash($user->password, PASSWORD_ARGON2I);
            $user->active_status = "0";
            $user->save();
        }
        return $user;
    }
}
