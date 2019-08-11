<?php

namespace Ksb\Logic;

use Bootstrap\Exception\ValidationException;
use Bootstrap\Helper\Mailer\BootstrapMailer;
use Bootstrap\Helper\Validation\BootstrapValidator;
use Bootstrap\Interfaces\JwtSubjectInterface;
use Bootstrap\Utility\Str;
use Bootstrap\Utility\Time;
use Firebase\JWT\JWT;
use Illuminate\Database\Capsule\Manager;
use Ksb\Logic\AuthLogic;
use Ksb\Model\User;
use Ksb\Validation\Rule\PasswordMatchRule;
use Ksb\Validation\Rule\UserActivedRule;
use Ksb\Validation\Rule\UserExistRule;

class UserLogic
{
    protected $authLogic;
    protected $mailer;
    protected $db;
    protected $activeTokenLength = 16;

    /**
     * Construct
     *
     * @param AuthLogic $authLogic
     * @return void
     */
    public function __construct(AuthLogic $authLogic, BootstrapMailer $mailer, Manager $db)
    {
        $this->authLogic = $authLogic;
        $this->mailer = $mailer;
        $this->db = $db;
    }

    /**
     * Login bằng email và mật khẩu
     *
     * @param [type] $email
     * @param [type] $password
     * @return void
     */
    public function loginByCrendential($email, $password)
    {
        $v = new BootstrapValidator();
        $v->setData([
            "email" => $email,
            "password" => $password,
        ]);

        // Email
        $v->addRule("email",
            [
                "fieldName" => "Email",
                "rule" => "require | email | minLength:6 | maxLength:100 | userExist | userActived",
            ]
        );

        // Mật khẩu
        $v->addRule("password",
            [
                "fieldName" => "Mật khẩu",
                "rule" => "require | password | passwordMatch:" . $email,
            ]
        );

        $v->addClassPath(UserExistRule::class);
        $v->addClassPath(PasswordMatchRule::class);
        $v->addClassPath(UserActivedRule::class);

        if ($v->isPassed()) {
            $user = User::where("email", $email)->first();
            return $this->buildToken($user);
        }

        throw new ValidationException($v);
    }

    /**
     * Build Token
     *
     * @param JwtSubjectInterface $user
     * @return void
     */
    protected function buildToken(JwtSubjectInterface $user)
    {
        $payload = $this->buildPayload($user);
        return JWT::encode($payload, getenv("JWT_SECRET"));
    }

    /**
     * Build JWT payload
     *
     * @param JwtSubjectInterface $user
     * @return void
     */
    protected function buildPayload(JwtSubjectInterface $user)
    {
        return [
            "iss" => $_SERVER["REQUEST_URI"],
            "sub" => $user->getSubject(),
            "iat" => Time::nowTimestamp(),
            "nbf" => Time::nowTimestamp(),
            "exp" => Time::now()->addHours(getenv("JWT_TTL"))->timestamp,
            "jti" => Str::randomStr(64),
        ];
    }

    /**
     * Đăng ký user mới
     *
     * @param User $user
     * @return void
     */
    // public function register(User $user)
    // {
    //     $user->userName = Str::trim($user->userName);

    //     $v = new BootstrapValidator();
    //     $v->setData($user->getAttributesCamel());

    //     // Tên hiển thị
    //     $v->addRule("userName",
    //         [
    //             "fieldName" => "Tên hiển thị",
    //             "rule" => [
    //                 "require",
    //                 "vietnameseCharacter",
    //                 "minLength:6",
    //                 "maxLength:50",
    //                 "userUnique",
    //             ],
    //         ]
    //     );

    //     // Email
    //     $v->addRule("email",
    //         [
    //             "fieldName" => "Email",
    //             "rule" => [
    //                 "require",
    //                 "email",
    //                 "minLength:6",
    //                 "maxLength:100",
    //                 "userUnique",
    //             ],
    //         ]
    //     );

    //     // Mật khẩu
    //     $v->addRule("password",
    //         [
    //             "fieldName" => "Mật khẩu",
    //             "rule" => [
    //                 "require",
    //                 "password",
    //                 "minLength:6",
    //                 "maxLength:100",
    //             ],
    //         ]
    //     );

    //     $v->addClassPath(UserUniqueRule::class);

    //     if ($v->isPassed()) {
    //         $this->doRegister($user);
    //     } else {
    //         $this->flash->addError($v->getErrors());
    //     }

    //     return $user;
    // }

    /**
     * Đăng ký người dùng mới
     *
     * @param User $user
     * @return void
     */
    // protected function doRegister(User $user)
    // {
    //     $this->db->getConnection()->beginTransaction();
    //     $activeToken = Str::randomStr($this->activeTokenLength);
    //     $tokenValidTime = Time::now()->addHours(1);
    //     try {
    //         $user->password = password_hash($user->password, PASSWORD_ARGON2I);
    //         if (!getenv("DEBUG")) {
    //             $user->active_status = "0";
    //         } else {
    //             $user->active_status = "1";
    //         }
    //         $user->save();

    //         UserActive::create([
    //             "user_id" => $user->id,
    //             "active_token" => $activeToken,
    //             "token_valid_time" => $tokenValidTime,
    //         ]);
    //         $this->db->getConnection()->commit();
    //     } catch (Exception $e) {
    //         $this->db->getConnection()->rollback();
    //     }
    //     // TODO chuyển sang dùng job queue
    //     if (!getenv("DEBUG")) {
    //         $this->mailer->sendRegisterMail($user->email, $user->id, $user->userName, $activeToken);
    //     }
    //     return true;
    // }

    /**
     * Đăng xuất
     *
     * @return void
     */
    // public function logout()
    // {
    //     $this->authLogic->logout();
    // }
}
