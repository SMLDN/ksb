<?php
namespace Ksb\Model;

use Bootstrap\Model\BootstrapModel;
use Ksb\Model\SheetTag;

class Tag extends BootstrapModel
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
