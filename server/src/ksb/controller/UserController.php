<?php

namespace Ksb\Controller;

use Bootstrap\Utility\Time;
use Ksb\Model\User;
use Ksb\Model\UserActive;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteParser;
use Slim\Views\Twig;

class UserController
{
    protected $view;
    protected $router;

    /**
     * Construct
     *
     * @param Twig $view
     * @param UserLogic $userLogic
     * @param RouteParser $router
     */
    public function __construct(Twig $view)
    {
        $this->view = $view;
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
