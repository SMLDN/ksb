<?php
namespace Ksb\Model;

use Bootstrap\Model\BootstrapModel;

class UserActive extends BootstrapModel
{
    protected $table = "user_active";
    protected $primaryKey = "user_id";
    protected $visible = [];
    protected $fillable = ["user_id", "active_token", "token_valid_time"];
}
