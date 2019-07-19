<?php

namespace Bootstrap\Model;

use Bootstrap\Utility\Str;
use Illuminate\Database\Eloquent\Model;

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

    /**
     * Lấy entity với tên key dạng camel case
     *
     * @return void
     */
    public function toArrayCamel()
    {
        $camelArray = [];

        $arrays = $this->toArray();
        foreach ($arrays as $key => $value) {
            $camelArray[Str::camel($key)] = $value;
        }

        return $camelArray;
    }

    /**
     * Thêm Validation errors
     *
     * @param [type] $value
     * @return void
     */
    public function setValidationErrors($value)
    {
        $this->validationErrors = $value;
    }

    /**
     * Lấy giá trị validation errors
     *
     * @return void
     */
    public function getValidationErrors()
    {
        return $this->validationErrors;
    }
}
