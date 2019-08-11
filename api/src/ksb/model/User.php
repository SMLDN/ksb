<?php
namespace Ksb\Model;

use Aloha\Interfaces\JwtSubjectInterface;
use Aloha\Model\AlohaModel;
use Ksb\Model\Sheet;

class User extends AlohaModel implements JwtSubjectInterface
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
