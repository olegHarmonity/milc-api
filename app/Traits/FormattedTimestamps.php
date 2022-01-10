<?php
namespace App\Traits;

trait FormattedTimestamps
{

    public static $FORMAT = 'Y-m-d H:i';

    public function getCasts()
    {
        return array_merge($this->casts, [
            'created_at' => 'datetime:' . self::$FORMAT,
            'updated_at' => 'datetime:' . self::$FORMAT
        ]);
    }

    public function getCreatedAtAttribute($value)
    {
        return $this->changeTimezone($value);
    }

    public function getUpdatedAtAttribute($value)
    {
        return $this->changeTimezone($value);
    }

    private function changeTimezone($value)
    {
        $date = new \DateTime($value);
        $date->setTimezone(new \DateTimeZone(config('app.timezone')));
        return $date->format(self::$FORMAT);
    }
}