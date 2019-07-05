<?php

namespace Ksb\Controller;

use Slim\Views\Twig;

class BaseController
{

    protected $view;

    public function __construct(Twig $view)
    {
        $this->view = $view;
    }

}
