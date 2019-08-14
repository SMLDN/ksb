<?php

namespace Ksb\Controller;

use Aloha\Utility\Str;
use Fig\Http\Message\StatusCodeInterface;
use Ksb\Logic\AuthLogic;
use Ksb\Logic\UserActiveLogic;
use Ksb\Model\User;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteParser;
use Slim\Views\Twig;

class UserController
{
    protected $authLogic;
    protected $userActiveLogic;

    /**
     * Construct
     *
     * @param Twig $view
     * @param UserLogic $userLogic
     * @param RouteParser $router
     */
    public function __construct(AuthLogic $authLogic, UserActiveLogic $userActiveLogic)
    {
        $this->authLogic = $authLogic;
        $this->userActiveLogic = $userActiveLogic;
    }

    /**
     * Người dùng hiện tại
     *
     * @return void
     */
    public function me(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $user = $this->authLogic->getUser();

        return $response->withJson([
            "user" => $user,
        ]);
    }

    /**
     * Trang kích hoạt tài khoản GET
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param [type] $args
     * @return void
     */
    public function activeGet(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $userId = $args["userId"] ?? null;
        $activeToken = $args["activeToken"] ?? null;

        if ($this->userActiveLogic->active($userId, $activeToken)) {
            return $response->withStatus(StatusCodeInterface::STATUS_OK);
        }
        return $response->withStatus(StatusCodeInterface::STATUS_BAD_REQUEST);
    }
}
