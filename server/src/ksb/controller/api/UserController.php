<?php

namespace Ksb\Controller\Api;

use Bootstrap\Utility\Str;
use Bootstrap\Utility\Time;
use Fig\Http\Message\StatusCodeInterface;
use Ksb\Logic\AuthLogic;
use Ksb\Model\User;
use Ksb\Model\UserActive;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteParser;
use Slim\Views\Twig;

class UserController
{
    protected $view;
    protected $authLogic;

    /**
     * Construct
     *
     * @param Twig $view
     * @param UserLogic $userLogic
     * @param RouteParser $router
     */
    public function __construct(Twig $view, AuthLogic $authLogic)
    {
        $this->view = $view;
        $this->authLogic = $authLogic;
    }

    /**
     * Người dùng hiện tại
     *
     * @return void
     */
    public function me(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $user = $this->authLogic->getUser();

        if ($user) {
            return $response->withJson([
                "user" => $user,
            ]);
        }

        return $response->withStatus(StatusCodeInterface::STATUS_UNAUTHORIZED);
    }

    /**
     * Người dùng khác
     *
     * @return void
     */
    public function home(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $userId = $args["userId"] ?? null;
        if (Str::equal($userId, $this->authLogic->getUserId())) {
            return $response->redirectTo("me.home");
        }
        $user = User::find($userId);

        if ($user) {
            return $this->view->render($response, "user/Home.twig", [
                "user" => $user->toArrayCamel(),
                "userRaw" => $user,
            ]);
        }

        return $response->redirectTo("home");
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
        if ($userId == null || $activeToken == null) {
            return $response->redirectTo("home");
        }

        $userActive = UserActive::find($userId);
        if ($userActive) {
            if ($userActive->activeToken == $activeToken && !Time::isTimeOver($userActive->tokenValidTime)) {
                $user = User::find($userId);
                if ($user) {
                    // kích hoạt thành công
                    $user->activeStatus = "1";
                    $user->save();
                    $this->view->getEnvironment()->addGlobal("userName", $user->userName);
                    $userActive->delete();
                    return $this->view->render($response, "user/Active.twig");
                }
            }
            // user không tồn tại này nọ
            $userActive->delete();
            return $response->redirectTo("home");
        }
        // thông tin ảo
        return $response->redirectTo("home");
    }
}
