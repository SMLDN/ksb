<?php
namespace Ksb\Model;

use Bootstrap\Model\BootstrapModel;
use Ksb\Model\User;

class Sheet extends BootstrapModel
{
    protected $table = "sheet";
    protected $primaryKey = "sheet_id";
    protected $visible = ["title", "content", "created_at", "updated_at"];
    protected $fillable = ["title", "content"];

    /**
     * Tham chiếu bảng User
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }
}
