<?php
namespace Ksb\Controller;

use Aloha\Exception\ValidationException;
use Aloha\Utility\CollectionUtil;
use Aloha\Utility\Str;
use Exception;
use Fig\Http\Message\StatusCodeInterface;
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
    public function createPost(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $sheet = new Sheet();
        $sheet->fill([
            "title" => $request->getParsedBody()["title"] ?? null,
            "content" => $request->getParsedBody()["content"] ?? null,
        ]);

        $tags = $request->getParsedBody()["tags"] ?? null;

        try {
            $this->sheetLogic->create($sheet, $tags);
            return $response->withJson([
                "sheet" => $sheet->toArrayCamel(),
            ]);
        } catch (ValidationException $e) {
            return $response->withJson($e->getValidationError())->withStatus(StatusCodeInterface::STATUS_NOT_ACCEPTABLE);
        } catch (Exception $e) {
            return $response->withJson([])->withStatus(StatusCodeInterface::STATUS_NOT_ACCEPTABLE);
        }
    }

    /**
     * Chỉnh sửa sheet
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param [type] $args
     * @return void
     */
    public function modifyPut(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $slug = $request->getParsedBody()["slug"] ?? null;
        $argSlug = $args["slug"] ?? null;

        if (!Str::equal($slug, $argSlug)) {
            return $response->withJson([])->withStatus(StatusCodeInterface::STATUS_NOT_ACCEPTABLE);
        }

        $sheet = new Sheet();
        $sheet->fill([
            "title" => $request->getParsedBody()["title"] ?? null,
            "content" => $request->getParsedBody()["content"] ?? null,
        ]);
        $sheet->slug = $slug;

        $tags = $request->getParsedBody()["tags"] ?? null;

        try {
            $this->sheetLogic->modify($sheet, $tags);
            return $response->withJson([]);
        } catch (ValidationException $e) {
            return $response->withJson($e->getValidationError())->withStatus(StatusCodeInterface::STATUS_NOT_ACCEPTABLE);
        } catch (Exception $e) {
            return $response->withJson([])->withStatus(StatusCodeInterface::STATUS_NOT_ACCEPTABLE);
        }
    }

    /**
     * Xem sheet
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param [type] $args
     * @return void
     */
    public function viewGet(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $userId = $args["userId"] ?? null;
        $slug = $args["slug"] ?? null;

        $sheet = $this->sheetLogic->getSheetBySlug($slug);
        if ($sheet && $sheet->userId == $userId) {
            return $response->withJson([
                "sheet" => $sheet->toArrayCamel(),
            ]);
        } else {
            return $response->withJson([])->withStatus(StatusCodeInterface::STATUS_NOT_FOUND);
        }
    }

    /**
     * Latest Sheet List GET
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param [type] $args
     * @return void
     */
    public function latestGet(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $sheetList = $this->sheetLogic->getLatestSheet();
        return $response->withJson([
            "sheetList" => CollectionUtil::toArrayCamel($sheetList, ["content"], ["user"]),
        ]);
    }
}
