<?php
namespace Bootstrap\Utility;

use Illuminate\Support\Carbon;

class Time extends Carbon
{
    /**
     * Giờ hiện tại theo timestamp
     *
     * @return void
     */
    public static function nowTimestamp()
    {
        return static::now()->timestamp;
    }
}
