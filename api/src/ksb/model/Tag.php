<?php
namespace Ksb\Model;

use Aloha\Model\AlohaModel;
use Ksb\Model\SheetTag;

class Tag extends AlohaModel
{
    protected $table = "tag";

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
