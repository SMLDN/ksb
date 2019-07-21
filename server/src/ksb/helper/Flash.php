<?php

namespace Ksb\Helper;

use Bootstrap\Helper\SessionManager;
use Bootstrap\Utility\Str;
use Slim\Views\Twig;

class Flash
{
    protected $view;
    protected $prefix = "flash_";

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
     * Thêm info flash
     *
     * @param [type] $info
     * @return void
     */
    public function addInfo($info)
    {
        SessionManager::set($this->prefix . "infos", $info);
    }

    /**
     * Thêm error flash
     *
     * @param [type] $error
     * @return void
     */
    public function addError($error)
    {
        SessionManager::set($this->prefix . "errors", $error);
    }

    /**
     * Thêm flash msg vào biến môi trường của Twig
     *
     * @return void
     */
    public function setGlobalFlash()
    {
        $this->setFlash($this->prefix . "infos");
        $this->setFlash($this->prefix . "errors");
    }

    /**
     * Thiết lập giá trị tạm thời
     *
     * @param Twig $view
     * @param [type] $key
     * @return void
     */
    protected function setFlash(string $key)
    {
        if (SessionManager::get($key) != null) {
            $this->view->getEnvironment()->addGlobal(Str::camel($key), SessionManager::get($key));
            SessionManager::reset($key);
        }
    }
}
