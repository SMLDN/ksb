<?php

namespace Ksb\Controller;

use Ksb\Logic\AuthLogic;
use Ksb\Logic\SheetLogic;
use Ksb\Model\Sheet;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class SheetController
{
    protected $authLogic;
    protected $sheetLogic;

    /**
     * Construct
     *
     * @param Twig $view
     */
    public function __construct(AuthLogic $authLogic, SheetLogic $sheetLogic)
    {
        $this->authLogic = $authLogic;
        $this->sheetLogic = $sheetLogic;
    }

    /**
     * Tạo sheet POST
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param [type] $args
     * @return void
     */
    // public function createPost(ServerRequestInterface $request, ResponseInterface $response, $args)
    // {

    //     $sheet = new Sheet();
    //     $sheet->fill([
    //         "title" => $request->getParsedBody()["title"] ?? null,
    //         "content" => $request->getParsedBody()["content"] ?? null,
    //     ]);

    //     $tags = $request->getParsedBody()["tag"] ?? null;

    //     if ($this->sheetLogic->create($sheet, $tags)) {
    //         if ($request->getUploadedFiles()) {
    //             $this->sheetLogic->uploadFiles($request->getUploadedFiles(), $this->authLogic->getUserRaw(), $sheet);
    //         }
    //         return $response->redirectTo("home");
    //     }

    //     return $response->redirectTo("me.sheet.create");
    // }
}
