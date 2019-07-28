<?php
namespace Ksb\Model;

use Bootstrap\Model\BootstrapModel;

class Sheet extends BootstrapModel
{
    protected $table = "sheet";
    protected $primaryKey = "sheet_id";
    protected $visible = ["title", "content", "created_at", "updated_at"];
    protected $fillable = ["title", "content"];
}
