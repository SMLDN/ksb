<?php

namespace Ksb\Logic;

use Bootstrap\Helper\BootstrapValidator;
use Ksb\Model\User;
use Ksb\Validation\Rule\UserUniqValidRule;

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
     * Undocumented function
     *
     * @param User $user
     * @return void
     */
    public function register(User $user)
    {
        $v = new BootstrapValidator(
            $user->getAttributesCamel(),
            [
                "userName" => [
                    "fieldName" => "Tên hiển thị",
                    "rule" => [
                        "require",
                        "alpha",
                        "userUniqValid",
                    ],
                ],
                "email" => [
                    "fieldName" => "Email",
                    "rule" => [
                        "require",
                        "userUniqValid",
                    ],
                ],
                "password" => [
                    "fieldName" => "Mật khẩu",
                    "rule" => "require",
                ],
            ],
            [UserUniqValidRule::class]
        );

        if ($v->validate()) {
            $user->password = password_hash($user->password, PASSWORD_BCRYPT, ["cost" => 10]);
            $user->save();
        }
        return $user;
    }
}
