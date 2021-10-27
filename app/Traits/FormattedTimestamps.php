<?php

namespace App\Traits;

trait FormattedTimestamps
{
    public function getCasts()
    {
        return array_merge($this->casts,
            [
                'created_at' => 'datetime:Y-m-d H:i',
                'updated_at' => 'datetime:Y-m-d H:i'
            ]
        );
    }
}
