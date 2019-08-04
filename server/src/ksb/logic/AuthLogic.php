<?php
namespace Ksb\Logic;

use Firebase\JWT\JWT;
use Ksb\Model\User;
use Psr\Http\Message\ServerRequestInterface;

class AuthLogic
{
    protected $user;

    /**
     * Undocumented function
     *
     * @return void
     */
    public function loginByHeader(ServerRequestInterface $request)
    {
        $header = $request->getHeader("Authorization");
        if ($header) {
            if (preg_match('/Bearer\s(\S+)/', $header[0], $matches)) {
                $token = $matches[1];
                $payload = JWT::decode($token, getenv("JWT_SECRET"), ["HS256"]);
                $this->user = User::find($payload->sub);
            }
        }
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
    public function getUserRaw()
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
