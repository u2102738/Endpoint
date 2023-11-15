<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceState extends Model
{
    use HasFactory;

    protected $table = 'device_state';
    protected $fillable = [
        'device_id',
        'uptime',
        'state',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

}
