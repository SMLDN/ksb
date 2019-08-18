<?php
namespace Aloha\Utility;

use Illuminate\Support\Collection;

class CollectionUtil
{
    /**
     * To Array Camel
     *
     * @param Collection $object
     * @return void
     */
    public static function toArrayCamel(Collection $object, array $excludes = [], array $relations = [])
    {
        $camelArray = [];
        $items = $object->all();
        foreach ($items as $item) {
            $camelItem = $item->toArrayCamelWithExclude($excludes);
            foreach ($relations as $r) {
                if ($item->{$r}) {
                    $camelItem[$r] = $item->{$r}->toArrayCamel();
                }
                continue;
            }
            \array_push($camelArray, $camelItem);
        }
        return $camelArray;
    }
}
