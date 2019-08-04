<?php
namespace Ksb\Model;

use Bootstrap\Interfaces\JwtSubjectInterface;
use Bootstrap\Model\BootstrapModel;
use Ksb\Model\Sheet;

class User extends BootstrapModel implements JwtSubjectInterface
{
    protected $table = "user";
    protected $visible = ["id", "email", "user_name"];

    /**
     * Tham chiếu bảng Sheet
     *
     * @return void
     */
    public function sheets()
    {
        return $this->hasMany(Sheet::class)->orderBy("id");
    }

    /**
     * @inheritDoc
     *
     * @return void
     */
    public function getSubject()
    {
        return $this->getKey();
    }
}
