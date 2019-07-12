<?php
namespace Ksb\Model;

use Bootstrap\Model\BootstrapModel;

class User extends BootstrapModel
{
    protected $table = "user";
    protected $primaryKey = 'user_id';
}
