<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceGroup extends Model
{
    use HasFactory;

    protected $table = 'device_group';

    protected $fillable = [
        'group_id',
        'device_id',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function devices()
    {
        return $this->belongsToMany(Device::class, 'device_group', 'group_id', 'device_id');
    }
}
