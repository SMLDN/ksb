<?php
namespace Ksb\Model;

use Aloha\Model\AlohaModel;

class UserActive extends AlohaModel
{
    protected $table = "user_active";
    protected $primaryKey = "user_id";
    protected $visible = [];
    protected $fillable = ["user_id", "active_token", "token_valid_time"];
}
