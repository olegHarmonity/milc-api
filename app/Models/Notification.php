<?php

namespace App\Models;

use App\Traits\FormattedTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory, FormattedTimestamps;
    
    protected $fillable = [
        'title',
        'message',
        'is_read',
        'category',
        'organisation_id',
        'sender_id',
        'is_for_admin'
    ];
    
    public function organisation()
    {
        return $this->belongsTo(Organisation::class);
    }
    
    public function sender()
    {
        return $this->belongsTo(Organisation::class, 'sender_id');
    }
    
}