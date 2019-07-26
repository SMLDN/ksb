<?php

namespace Ksb\Logic;

use Bootstrap\Helper\Validation\BootstrapValidator;
use Bootstrap\Utility\Str;
use Ksb\Helper\Flash;
use Ksb\Logic\AuthLogic;
use Ksb\Model\Sheet;

class SheetLogic
{
    protected $authLogic;
    protected $flash;

    /**
     * Construct
     *
     * @param AuthLogic $authLogic
     * @return void
     */
    public function __construct(AuthLogic $authLogic, Flash $flash)
    {
        $this->authLogic = $authLogic;
        $this->flash = $flash;
    }

    /**
     * Tạo sheet
     *
     * @param Sheet $sheet
     * @return void
     */
    public function create(Sheet $sheet)
    {
        $sheet->title = Str::trim($sheet->title);

        $v = new BootstrapValidator();
        $v->setData($sheet->getAttributesCamel());

        // Tiêu đề
        $v->addRule("title",
            [
                "fieldName" => "Tiêu đề",
                "rule" => [
                    "require",
                    "maxLength:255",
                ],
            ]
        );

        // Nội dung
        $v->addRule("content",
            [
                "fieldName" => "Nội dung bài viết",
                "rule" => [
                    "require",
                    "minLength:4",
                    "maxLength:9999",
                ],
            ]
        );

        if ($v->isPassed()) {
            $sheet->userId = $this->authLogic->getRawUser()->userId;
            $sheet->save();
            return true;
        }

        return false;
    }
}
