<?php

namespace Ksb\Logic;

use Bootstrap\Helper\Validation\BootstrapValidator;
use Bootstrap\Utility\Str;
use Ksb\Helper\Flash;
use Ksb\Logic\AuthLogic;
use Ksb\Model\Sheet;
use Ksb\Model\SheetAttach;
use Ksb\Model\User;

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
                    "maxLength:99999",
                ],
            ]
        );

        if ($v->isPassed()) {
            $sheet->slug = Str::makeSlugStr($sheet->title);
            $sheet->user()->associate($this->authLogic->getUserRaw());
            $sheet->save();
            return true;
        }

        return false;
    }

    /**
     * Chỉnh sửa sheet
     *
     * @param Sheet $sheet
     * @return void
     */
    public function edit(Sheet $sheet)
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
                    "maxLength:99999",
                ],
            ]
        );

        if ($v->isPassed()) {
            $sheet->save();
            return true;
        }

        return false;
    }

    /**
     * Uplaod Files
     *
     * @param [type] $files
     * @param User $user
     * @param Sheet $sheet
     * @return void
     */
    public function uploadFiles($files, User $user, Sheet $sheet)
    {
        foreach ($files as $file) {
            if ($file->getClientFilename()) {
                $sheetAttach = new SheetAttach();
                $sheetAttach->attachContent = $file;
                $sheetAttach->userId = $user->id;
                $sheetAttach->sheetId = $sheet->id;
                $sheetAttach->attachName = $file->getClientFilename();
                $sheetAttach->save();
            }
        }
    }

    /**
     * Tìm sheet dựa vào slug
     *
     * @param string $slug
     * @return void
     */
    public function getSheetBySlug(string $slug)
    {
        if ($this->isSlugValid($slug)) {
            $sheet = Sheet::where("slug", $slug)->first();
            return $sheet ? $sheet->toArrayCamel() : null;
        }

        return null;
    }

    /**
     * Tìm sheet phiên bản full dựa vào slug
     *
     * @param string $slug
     * @return void
     */
    public function getRawSheetBySlug(string $slug)
    {
        $sheet = Sheet::where("slug", $slug)->first();
        return $sheet ?? null;
    }
}
