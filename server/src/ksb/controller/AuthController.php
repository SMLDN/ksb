<?php

namespace Ksb\Controller;

use Bootstrap\Helper\SessionManager;
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
        SessionManager::setFlash($this->view, "flash_errors");
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
        $user->email = $request->getParsedBody()["email"] ?? "";
        $user->password = $request->getParsedBody()["loginPassword"] ?? "";

        if ($this->userLogic->login($user)) {
            return $response->withRedirect($this->router->urlFor("index"));
        }

        SessionManager::set("flash_errors", $user->getValidationErrors());
        return $response->withRedirect($this->router->urlFor("auth.login"));
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
        SessionManager::setFlash($this->view, "flash_errors");
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

        $user->email = $request->getParsedBody()["email"] ?? "";
        $user->userName = $request->getParsedBody()["userName"] ?? "";
        $user->password = $request->getParsedBody()["loginPassword"] ?? "";

        $this->userLogic->register($user);
        if ($user->userId) {
            return $response->withRedirect($this->router->urlFor("index"));
        }

        SessionManager::set("flash_errors", $user->getValidationErrors());
        return $response->withRedirect($this->router->urlFor("auth.register"));
    }
}
