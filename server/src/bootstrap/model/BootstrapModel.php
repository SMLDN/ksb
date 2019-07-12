<?php

namespace Bootstrap\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BootstrapModel extends Model
{

    /**
     * getAttribute Override
     *
     * @param [type] $key
     * @return void
     */
    public function getAttribute($key)
    {
        return parent::getAttribute(Str::snake($key));
    }

    /**
     * setAttribute Override
     *
     * @param [type] $key
     * @param [type] $value
     * @return void
     */
    public function setAttribute($key, $value)
    {
        return parent::setAttribute(Str::snake($key), $value);
    }

    /**
     * Lấy tất cả attributes với tên key dạng camel case
     *
     * @return void
     */
    public function getAttributesCamel()
    {
        $camelAttributes = [];

        $attributes = $this->getAttributes();
        foreach ($attributes as $key => $value) {
            $camelAttributes[Str::camel($key)] = $value;
        }

        return $camelAttributes;
    }
}
