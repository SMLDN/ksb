<?php
namespace Ksb\Model;

use Bootstrap\Model\BootstrapModel;

class Sheet extends BootstrapModel
{
    protected $table = "sheet";
    protected $primaryKey = "sheet_id";
    protected $visible = ["title", "content"];
    protected $fillable = ["title", "content"];
}
