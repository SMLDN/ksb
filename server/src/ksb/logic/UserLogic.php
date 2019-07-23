<?php

namespace Ksb\Logic;

use Bootstrap\Helper\Mailer\BootstrapMailer;
use Bootstrap\Helper\Validation\BootstrapValidator;
use Bootstrap\Utility\Str;
use Bootstrap\Utility\Time;
use Exception;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Support\Facades\DB;
use Ksb\Helper\Flash;
use Ksb\Logic\AuthLogic;
use Ksb\Model\User;
use Ksb\Model\UserActive;
use Ksb\Validation\Rule\PasswordMatchRule;
use Ksb\Validation\Rule\UserActivedRule;
use Ksb\Validation\Rule\UserExistRule;
use Ksb\Validation\Rule\UserUniqueRule;

class UserLogic
{
    protected $authLogic;
    protected $mailer;
    protected $db;
    protected $flash;
    protected $activeTokenLength = 32;

    /**
     * Construct
     *
     * @param AuthLogic $authLogic
     * @return void
     */
    public function __construct(AuthLogic $authLogic, BootstrapMailer $mailer, Manager $db, Flash $flash)
    {
        $this->authLogic = $authLogic;
        $this->mailer = $mailer;
        $this->db = $db;
        $this->flash = $flash;
    }

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
                    "userActived",
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
        $v->addClassPath(UserActivedRule::class);

        if ($v->isPassed()) {
            $user = User::where("email", $user->email)->first();
            $this->authLogic->loginFromProgram($user);
            return true;
        }

        $this->flash->addError($v->getErrors());
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
        $user->userName = Str::trim($user->userName);

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
            $this->flash->addError($v->getErrors());
        }

        return $user;
    }

    /**
     * Đăng ký người dùng mới
     *
     * @param User $user
     * @return void
     */
    protected function doRegister(User $user)
    {
        $this->db->getConnection()->beginTransaction();
        $activeToken = substr(bin2hex(random_bytes($this->activeTokenLength)), 0, $this->activeTokenLength);
        $tokenValidTime = Time::now()->addHours(1);
        try {
            $user->password = password_hash($user->password, PASSWORD_ARGON2I);
            $user->active_status = "0";
            $user->save();

            UserActive::create([
                "user_id" => $user->userId,
                "active_token" => $activeToken,
                "token_valid_time" => $tokenValidTime,
            ]);
            $this->db->getConnection()->commit();
        } catch (Exception $e) {
            $this->db->getConnection()->rollback();
        }
        // TODO chuyển sang dùng job queue
        $this->mailer->sendRegisterMail($user->email, $user->userId, $user->userName, $activeToken);
        return true;
    }

    /**
     * Đăng xuất
     *
     * @return void
     */
    public function logout()
    {
        $this->authLogic->logout();
    }

}
