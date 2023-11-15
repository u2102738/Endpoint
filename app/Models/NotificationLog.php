<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationLog extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'notification_log';
    protected $fillable = [
        'user_id',
        'activity_id',
        'is_read',
    ];

    public function activity()
    {
        return $this->belongsTo(ActivityLog::class, 'activity_id');
    }
}
