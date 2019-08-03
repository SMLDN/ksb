<?php

namespace Ksb\Controller;

use Ksb\Logic\AuthLogic;
use Ksb\Logic\SheetLogic;
use Ksb\Model\SheetAttach;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class SheetAttachController
{
    protected $view;
    protected $authLogic;
    protected $sheetLogic;

    /**
     * Construct
     *
     * @param Twig $view
     */
    public function __construct(Twig $view, AuthLogic $authLogic, SheetLogic $sheetLogic)
    {
        $this->view = $view;
        $this->authLogic = $authLogic;
        $this->sheetLogic = $sheetLogic;
    }

    /**
     * View GET
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param [type] $args
     * @return void
     */
    public function viewGet(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $sheetAttachId = $args["sheetAttachId"] ?? null;
        if ($sheetAttachId) {
            $sheetAttach = SheetAttach::find($sheetAttachId);
            if (!$sheetAttach) {
                return $response->redirectTo("home");
            }
            return $response->withAttach($sheetAttach->attachContent);
        }

        return $response->redirectTo("home");
    }
}
