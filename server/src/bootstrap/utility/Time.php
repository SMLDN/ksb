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

    /**
     * Kiểm tra xem đã quá hạn time chưa
     *
     * @param [type] $time
     * @param [type] $range
     * @return void
     */
    public static function isTimeOver(string $time)
    {
        $now = static::now();
        $time = static::parse($time);

        return $now >= $time;
    }
}
