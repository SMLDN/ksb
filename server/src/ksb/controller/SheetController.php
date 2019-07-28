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
     * Tạo sheet GET
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
     * Tạo sheet POST
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

    /**
     * Xem sheet GET
     *
     * @return void
     */
    public function viewGet(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $slug = $args["slug"] ?? null;

        $sheet = $this->sheetLogic->getSheetBySlug($slug);

        if ($sheet) {
            return $this->view->render($response, "sheet/View.twig", [
                "sheet" => $sheet,
            ]);
        }

        return $response->redirectTo("home");
    }

    /**
     * Chỉnh sửa Sheet GET
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param [type] $args
     * @return void
     */
    public function editGet(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $slug = $args["slug"] ?? null;

        $rawSheet = $this->sheetLogic->getRawSheetBySlug($slug);

        if ($rawSheet && $rawSheet->userId == $this->authLogic->getUserId()) {
            $sheet = $rawSheet->toArrayCamel();
            return $this->view->render($response, "sheet/Edit.twig", [
                "sheet" => $sheet,
            ]);
        }

        return $response->redirectTo("auth.login");
    }

    /**
     * Chỉnh xửa Sheet POST
     *
     * @return void
     */
    public function editPost(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $slug = $args["slug"] ?? null;

        $rawSheet = $this->sheetLogic->getRawSheetBySlug($slug);

        if ($rawSheet && $rawSheet->userId == $this->authLogic->getUserId()) {
            $rawSheet->fill([
                "title" => $request->getParsedBody()["title"] ?? null,
                "content" => $request->getParsedBody()["content"] ?? null,
            ]);

            if ($this->sheetLogic->edit($rawSheet)) {
                return $this->view->render($response, "sheet/Edit.twig", [
                    "sheet" => $rawSheet,
                ]);
            }
        }

        return $response->redirectTo("auth.login");
    }
}
