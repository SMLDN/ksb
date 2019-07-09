<?php

namespace Ksb\Logic;

use Ksb\Model\User;

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
}
