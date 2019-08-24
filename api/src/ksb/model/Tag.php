<?php
namespace Ksb\Model;

use Aloha\Model\AlohaModel;
use Ksb\Model\SheetTag;

class Tag extends AlohaModel
{
    protected $table = "tag";
    protected $visible = ["id", "name", "created_at", "updated_at"];

    /**
     * Tham chiếu Sheet
     *
     * @return void
     */
    public function sheets()
    {
        return $this->hasMany(SheetTag::class);
    }
}
