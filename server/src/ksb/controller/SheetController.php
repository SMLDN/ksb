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
     * Undocumented function
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param [type] $args
     * @return void
     */
    public function createGet(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        return $this->view->render($response, "sheet/Create.twig");
    }

    /**
     * Undocumented function
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param [type] $args
     * @return void
     */
    public function createPost(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $sheet = new Sheet();
        $sheet->fill([
            "title" => $request->getParsedBody()["title"] ?? null,
            "content" => $request->getParsedBody()["content"] ?? null,
        ]);
        if ($this->sheetLogic->create($sheet)) {
            return $response->redirectTo("home");
        }

        return $response->redirectTo("user.sheet.create");
    }
}
