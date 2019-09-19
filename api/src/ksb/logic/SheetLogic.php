<?php

namespace Ksb\Logic;

use Aloha\Exception\ValidationException;
use Aloha\Helper\Validation\AlohaValidator;
use Aloha\Utility\Str;
use Exception;
use Illuminate\Database\Capsule\Manager;
use Ksb\Logic\AuthLogic;
use Ksb\Model\Sheet;
use Ksb\Model\SheetTag;
use Ksb\Model\Tag;
use Ksb\Model\User;

class SheetLogic
{
    protected $authLogic;
    protected $db;

    /**
     * Construct
     *
     * @param AuthLogic $authLogic
     * @return void
     */
    public function __construct(AuthLogic $authLogic, Manager $db)
    {
        $this->authLogic = $authLogic;
        $this->db = $db;
    }

    /**
     * Tạo sheet
     *
     * @param Sheet $sheet
     * @return void
     */
    public function create(Sheet $sheet, $tags = "")
    {
        $sheet->title = Str::trim($sheet->title);

        // Validation
        try {
            $this->checkSheet($sheet);
        } catch (ValidationException $e) {
            throw $e;
        }

        $this->db->getConnection()->beginTransaction();
        try {
            $sheet->slug = Str::makeSlugStr($sheet->title);
            $sheet->user()->associate($this->authLogic->getUserRaw());
            $tagList = explode(" ", $tags);
            $sheet->save();

            $tagList = explode(" ", $tags);
            foreach ($tagList as $tag) {
                $tag = Tag::where("name", $tag)->first();
                if ($tag) {
                    $sheetTag = new SheetTag;
                    $sheetTag->tag()->associate($tag);
                    $sheetTag->sheet()->associate($sheet);
                    $sheetTag->save();
                }
            }
            $this->db->getConnection()->commit();
        } catch (Exception $e) {
            $this->db->getConnection()->rollback();
            throw new Exception;
        }
    }

    /**
     * Chỉnh sửa sheet
     *
     * @param Sheet $sheet
     * @return void
     */
    public function modify(Sheet $sheet, $tags = "")
    {
        $sheet->title = Str::trim($sheet->title);

        // Validation
        try {
            $this->checkSheet($sheet);
        } catch (ValidationException $e) {
            throw $e;
        }

        $currentSheet = Sheet::where("slug", $sheet->slug)->first();

        if (!$currentSheet || $currentSheet->userId != $this->authLogic->getUserId()) {
            throw new Exception;
        }

        $this->db->getConnection()->beginTransaction();
        try {
            $currentSheet->title = $sheet->title;
            $currentSheet->content = $sheet->content;
            $currentSheet->save();

            SheetTag::where("sheet_id", $currentSheet->id)->delete();
            $tagList = explode(" ", $tags);
            foreach ($tagList as $tag) {
                $tag = Tag::where("name", $tag)->first();
                if ($tag) {
                    $sheetTag = new SheetTag;
                    $sheetTag->tag()->associate($tag);
                    $sheetTag->sheet()->associate($currentSheet);
                    $sheetTag->save();
                }
            }
            $this->db->getConnection()->commit();
        } catch (Exception $e) {
            $this->db->getConnection()->rollback();
            throw new Exception;
        }

    }

    /**
     * Sheet Validation
     *
     * @param Sheet $sheet
     * @return void
     */
    protected function checkSheet(Sheet $sheet)
    {

        $v = new AlohaValidator();
        $v->setData($sheet->getAttributesCamel());

        // Tiêu đề
        $v->addRule("title",
            [
                "fieldName" => "Tiêu đề",
                "rule" => "require | maxLength:255",
            ]
        );

        // Nội dung
        $v->addRule("content",
            [
                "fieldName" => "Nội dung bài viết",
                "rule" => "require | minLength:4 | maxLength:99999",
            ]
        );

        if (!$v->isPassed()) {
            throw new ValidationException($v);
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
        return Sheet::where("slug", $slug)
            ->with("tags.tag")
            ->first();
    }

    /**
     * Tìm sheet phiên bản full dựa vào slug
     *
     * @param string $slug
     * @return void
     */
    public function getRawSheetBySlug(string $slug)
    {
        return Sheet::where("slug", $slug)
            ->first();
    }

    /**
     * Danh sách sheet mới nhất
     *
     * @return void
     */
    public function getLatestSheet()
    {
        $sheetList = Sheet::latest()
            ->take(15)
            ->with("user")
            ->get();
        return $sheetList;
    }
}
