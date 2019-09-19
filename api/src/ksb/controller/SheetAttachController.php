<?php

namespace Ksb\Controller;

use Fig\Http\Message\StatusCodeInterface;
use Ksb\Logic\AuthLogic;
use Ksb\Logic\SheetAttachLogic;
use Ksb\Model\SheetAttach;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class SheetAttachController
{
    protected $authLogic;
    protected $sheetAttachLogic;

    /**
     * Construct
     *
     * @param Twig $view
     */
    public function __construct(AuthLogic $authLogic, SheetAttachLogic $sheetAttachLogic)
    {
        $this->authLogic = $authLogic;
        $this->sheetAttachLogic = $sheetAttachLogic;
    }

    /**
     * Upload POST
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param [type] $args
     * @return void
     */
    public function createPost(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        if (($files = $request->getUploadedFiles()) && isset($files["attachContent"])) {
            $sheetAttach = $this->sheetAttachLogic
                ->uploadFile($files["attachContent"], $this->authLogic->getUserRaw());
            if ($sheetAttach != null) {
                return $response->withJson($sheetAttach->toArrayCamelWithDefaultExclude());
            }
        }

        return $response->withJson([])->withStatus(StatusCodeInterface::STATUS_NOT_ACCEPTABLE);
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
                return $response->withJson([])->withStatus(StatusCodeInterface::STATUS_NOT_ACCEPTABLE);
            }
            return $response->withAttach($sheetAttach->attachContent);
        }

        return $response->withJson([])->withStatus(StatusCodeInterface::STATUS_NOT_ACCEPTABLE);
    }
}
