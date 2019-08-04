<?php

namespace Ksb\Controller\Api;

use Fig\Http\Message\StatusCodeInterface;
use Ksb\Logic\UserLogic;
use Ksb\Model\User;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AuthController
{
    protected $userLogic;

    /**
     * Construct
     *
     * @param UserLogic $userLogic
     */
    public function __construct(UserLogic $userLogic)
    {
        $this->userLogic = $userLogic;
    }

    /**
     * Trang đăng nhập POST
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param [type] $args
     * @return void
     */
    public function loginPost(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $email = $request->getParsedBody()["email"] ?? null;
        $password = $request->getParsedBody()["loginPassword"] ?? null;

        if ($token = $this->userLogic->loginByCrendential($email, $password)) {
            return $response->withJson([
                "token" => $token,
            ]);
        }

        return $response->withStatus(StatusCodeInterface::STATUS_UNAUTHORIZED);
    }

    /**
     * Trang đăng ký POST
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param [type] $args
     * @return void
     */
    // public function registerPost(ServerRequestInterface $request, ResponseInterface $response, $args)
    // {
    //     $user = new User();

    //     $user->email = $request->getParsedBody()["email"] ?? null;
    //     $user->userName = $request->getParsedBody()["userName"] ?? null;
    //     $user->password = $request->getParsedBody()["loginPassword"] ?? null;

    //     $this->userLogic->register($user);
    //     if ($user->id) {
    //         return $response->redirectTo("home");
    //     }
    //     return $response->redirectTo("auth.register");
    // }
}
