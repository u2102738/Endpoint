<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ActivityLog extends Model
{
    use HasFactory;

    protected $table = 'activity_log';

    protected $fillable = [
        'user_id',
        'event_type',
        'event_status',
        'user_id_affected',
        'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function userAffected()
    {
        return $this->belongsTo(User::class, 'user_id_affected');
    }
}
