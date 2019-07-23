<?php

namespace Ksb\Controller;

use Ksb\Logic\UserLogic;
use Ksb\Model\User;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteParser;
use Slim\Views\Twig;

class AuthController
{
    protected $view;
    protected $userLogic;
    protected $router;
    protected $flash;

    /**
     * Construct
     *
     * @param Twig $view
     * @param UserLogic $userLogic
     * @param RouteParser $router
     */
    public function __construct(Twig $view, UserLogic $userLogic, RouteParser $router)
    {
        $this->view = $view;
        $this->userLogic = $userLogic;
        $this->router = $router;
    }

    /**
     * Trang đăng nhập GET
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param [type] $args
     * @return void
     */
    public function loginGet(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        return $this->view->render($response, "auth/Login.twig");
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

        $user = new User();
        $user->email = $request->getParsedBody()["email"] ?? null;
        $user->password = $request->getParsedBody()["loginPassword"] ?? null;

        if ($this->userLogic->login($user)) {
            return $response->withRedirect($this->router->urlFor("home"));
        }

        return $response->withRedirect($this->router->urlFor("auth.login"));
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
        return $response->withRedirect($this->router->urlFor("home"));
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
        if ($user->userId) {
            return $response->withRedirect($this->router->urlFor("home"));
        }

        return $response->withRedirect($this->router->urlFor("auth.register"));
    }
}
