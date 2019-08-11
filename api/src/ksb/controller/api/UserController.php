<?php

namespace Ksb\Controller\Api;

use Aloha\Utility\Str;
use Ksb\Logic\AuthLogic;
use Ksb\Model\User;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteParser;
use Slim\Views\Twig;

class UserController
{
    protected $authLogic;

    /**
     * Construct
     *
     * @param Twig $view
     * @param UserLogic $userLogic
     * @param RouteParser $router
     */
    public function __construct(AuthLogic $authLogic)
    {
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
    // public function activeGet(ServerRequestInterface $request, ResponseInterface $response, $args)
    // {
    //     $userId = $args["userId"] ?? null;
    //     $activeToken = $args["activeToken"] ?? null;
    //     if ($userId == null || $activeToken == null) {
    //         return $response->redirectTo("home");
    //     }

    //     $userActive = UserActive::find($userId);
    //     if ($userActive) {
    //         if ($userActive->activeToken == $activeToken && !Time::isTimeOver($userActive->tokenValidTime)) {
    //             $user = User::find($userId);
    //             if ($user) {
    //                 // kích hoạt thành công
    //                 $user->activeStatus = "1";
    //                 $user->save();
    //                 $this->view->getEnvironment()->addGlobal("userName", $user->userName);
    //                 $userActive->delete();
    //                 return $this->view->render($response, "user/Active.twig");
    //             }
    //         }
    //         // user không tồn tại này nọ
    //         $userActive->delete();
    //         return $response->redirectTo("home");
    //     }
    //     // thông tin ảo
    //     return $response->redirectTo("home");
    // }
}
