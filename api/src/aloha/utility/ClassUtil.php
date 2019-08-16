<?php
namespace Aloha\Utility;

use Aloha\Utility\Str;
use stdClass;

class ClassUtil
{
    /**
     * Chuyển đổi thuộc tính về dạng Camel
     *
     * @param [type] $object
     * @return void
     */
    public static function toCamel($object)
    {
        $objectCamel = new stdClass;
        $propList = get_object_vars($object);
        foreach ($propList as $prop => $value) {
            $objectCamel->{Str::camel($prop)} = $object->{$prop};
        }
        return $objectCamel;
    }

    /**
     * List về camel
     *
     * @param [type] $list
     * @return void
     */
    public static function listToCamel($list)
    {
        $listCamel = [];
        foreach ($list as $item) {
            array_push($listCamel, static::toCamel($item));
        }
        return $listCamel;
    }
}
