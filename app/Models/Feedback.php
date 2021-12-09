<?php

namespace App\Models;

use App\Traits\FormattedTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory, FormattedTimestamps;

    protected $fillable = [
        'user_id',
        'type',
        'content',
        'status',
        'is_archived',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
