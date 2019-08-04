<?php

namespace Ksb\Controller\Api;

use Fig\Http\Message\StatusCodeInterface;
use Ksb\Logic\UserLogic;
use Ksb\Model\User;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class AuthController
{
    protected $view;
    protected $userLogic;
    protected $flash;

    /**
     * Construct
     *
     * @param Twig $view
     * @param UserLogic $userLogic
     */
    public function __construct(Twig $view, UserLogic $userLogic)
    {
        $this->view = $view;
        $this->userLogic = $userLogic;
    }

    /**
     * Trang đăng nhập GET
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param [type] $args
     * @return void
     */
    // public function loginGet(ServerRequestInterface $request, ResponseInterface $response, $args)
    // {
    //     return $this->view->render($response, "auth/Login.twig");
    // }

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
     * Trang đăng xuất GET
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param [type] $args
     * @return void
     */
    public function logoutGet(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $this->userLogic->logout();
        return $response->redirectTo("home");
    }

    /**
     * Trang đăng ký GET
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param [type] $args
     * @return void
     */
    public function registerGet(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        return $this->view->render($response, "auth/Register.twig");
    }

    /**
     * Trang đăng ký POST
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param [type] $args
     * @return void
     */
    public function registerPost(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $user = new User();

        $user->email = $request->getParsedBody()["email"] ?? null;
        $user->userName = $request->getParsedBody()["userName"] ?? null;
        $user->password = $request->getParsedBody()["loginPassword"] ?? null;

        $this->userLogic->register($user);
        if ($user->id) {
            return $response->redirectTo("home");
        }
        return $response->redirectTo("auth.register");
    }
}
