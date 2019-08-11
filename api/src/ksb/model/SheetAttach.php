<?php
namespace Ksb\Model;

use Aloha\Model\AlohaModel;
use Ksb\Model\Sheet;
use Ksb\Model\User;

class SheetAttach extends AlohaModel
{
    protected $table = "sheet_attach";
    protected $visible = ["attach_content", "attach_name", "created_at", "updated_at"];
    protected $fillable = ["attach_content", "attach_name"];
    // UUID
    protected $keyType = "string";
    protected $useUuid = true;
    public $incrementing = false;

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
     * Tham chiếu bảng Sheet
     *
     * @return void
     */
    public function sheet()
    {
        return $this->belongsTo(Sheet::class);
    }
}
