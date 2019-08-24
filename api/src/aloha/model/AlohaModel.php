<?php

namespace Aloha\Model;

use Aloha\Utility\Str;
use Aloha\Utility\Upload;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Psr\Http\Message\UploadedFileInterface;
use Ramsey\Uuid\Uuid;

class AlohaModel extends Model
{
    protected $uuidVersion = 4;
    protected $keyType = "int";
    protected $useUuid = false;
    public $incrementing = true;

    /**
     * @inheritDoc
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (self $model): void {
            // Automatically generate a UUID if using them, and not provided.
            if ($model->useUuid && empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = $model->generateUuid();
            }
        });
    }

    /**
     * Tạo UUID
     *
     * @return string
     */
    protected function generateUuid(): string
    {
        switch ($this->uuidVersion) {
            case 1:
                return Uuid::uuid1()->toString();
            case 4:
                return Uuid::uuid4()->toString();
        }
        throw new Exception("UUID version [{$this->uuidVersion}] not supported.");
    }

    /**
     * @inheritDoc
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return bool
     */
    protected function performInsert(Builder $query)
    {
        if ($this->fireModelEvent('creating') === false) {
            return false;
        }

        // First we'll need to create a fresh query instance and touch the creation and
        // update timestamps on this model, which are maintained by us for developer
        // convenience. After, we will just continue saving these model instances.
        if ($this->usesTimestamps()) {
            $this->updateTimestamps();
        }

        // Tự động thêm id dạng UUID
        if ($this->useUuid && empty($this->attributes[$this->getKeyName()])) {
            $this->attributes[$this->getKeyName()] = $this->generateUuid();
        }

        // If the model has an incrementing key, we can use the "insertGetId" method on
        // the query builder, which will give us back the final inserted ID for this
        // table from the database. Not all tables have to be incrementing though.
        $attributes = $this->getAttributes();

        if ($this->getIncrementing()) {
            $this->insertAndSetId($query, $attributes);
        }

        // If the table isn't incrementing we'll simply insert these attributes as they
        // are. These attribute arrays must contain an "id" column previously placed
        // there by the developer as the manually determined key for these models.
        else {
            if (empty($attributes)) {
                return true;
            }

            $query->insert($attributes);
        }

        // We will go ahead and set the exists property to true, so that it is set when
        // the created event is fired, just in case the developer tries to update it
        // during the event. This will allow them to do so and run an update here.
        $this->exists = true;

        $this->wasRecentlyCreated = true;

        $this->fireModelEvent('created', false);

        return true;
    }

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
        if ($value instanceof UploadedFileInterface) {
            $value = Upload::encode($value);
        }
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
        foreach ($arrays as $key => $values) {
            $camelArray[Str::camel($key)] = $this->recursiveToCamel($values);
        }
        return $camelArray;
    }

    /**
     * Lấy tên key camel hồi quy
     *
     * @param [type] $value
     * @return void
     */
    protected function recursiveToCamel($values)
    {
        if (!\is_array($values)) {
            return $values;
        }

        $ret = [];
        foreach ($values as $k => $v) {
            $ret[Str::camel($k)] = $this->recursiveToCamel($v);
        }
        return $ret;
    }

    /**
     * Lấy entity với tên key dạng camel case (kèm loại trừ)
     *
     * @return void
     */
    public function toArrayCamelWithExclude(array $excludes)
    {
        if ($excludes === []) {
            return $this->toArrayCamel();
        }
        $camelArray = [];
        $arrays = $this->toArray();
        foreach ($arrays as $key => $value) {
            if (!\in_array($key, $excludes)) {
                $camelArray[Str::camel($key)] = $value;
            }
            continue;
        }

        return $camelArray;
    }
}
