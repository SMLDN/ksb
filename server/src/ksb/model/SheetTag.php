<?php
namespace Ksb\Model;

use Bootstrap\Model\BootstrapModel;
use Ksb\Model\Sheet;

class SheetTag extends BootstrapModel
{
    protected $table = "sheet_tag";
    protected $primaryKey = ["sheet_id", "tag_id"];
    public $timestamps = false;
    public $incrementing = false;

    /**
     * Tham chiếu bảng Sheet
     *
     * @return void
     */
    public function sheet()
    {
        return $this->belongsTo(Sheet::class);
    }

    /**
     * Tham chiếu bảng Tag
     *
     * @return void
     */
    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
}
