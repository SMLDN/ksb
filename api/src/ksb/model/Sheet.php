<?php
namespace Ksb\Model;

use Aloha\Model\AlohaModel;
use Ksb\Model\SheetAttach;
use Ksb\Model\SheetTag;
use Ksb\Model\User;

class Sheet extends AlohaModel
{
    protected $table = "sheet";
    protected $visible = ["title", "content", "created_at", "updated_at", "slug"];
    protected $fillable = ["title", "content"];

    /**
     * Tham chiếu bảng User
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Tham chiếu bảng SheetAttach
     *
     * @return void
     */
    public function sheetAttachs()
    {
        return $this->hasMany(SheetAttach::class);
    }

    /**
     * Tham chiếu bảng Tag
     *
     * @return void
     */
    public function tags()
    {
        return $this->hasMany(SheetTag::class);
    }

    /**
     * Danh sách Tag Name
     *
     * @return void
     */
    public function tagsName()
    {
        $sheetTags = $this->tags;
        $tagArray = [];
        foreach ($sheetTags as $sheetTag) {
            array_push($tagArray, $sheetTag->tag->name);
        }
        return $tagArray;
    }
}
