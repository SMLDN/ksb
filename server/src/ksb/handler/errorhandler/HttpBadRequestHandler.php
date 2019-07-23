<?php
namespace Ksb\Handler\Errorhandler;

use Exception;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Response;
use Slim\Views\Twig;

class HttpBadRequestHandler
{
    protected $view;

    /**
     * Construct
     *
     * @param Twig $view
     */
    public function __construct(Twig $view)
    {
        $this->view = $view;
    }

    /**
     * @inheritDoc
     *
     * @param ServerRequestInterface $request
     * @param Exception $exception
     * @return void
     */
    public function __invoke(ServerRequestInterface $request, Exception $exception)
    {
        $response = new Response(StatusCodeInterface::STATUS_BAD_REQUEST);
        return $this->view->render($response, "error/BadRequest.twig");
    }
}
