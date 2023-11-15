<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $table = 'groups';

    protected $fillable = [
        'name',
        'description',
    ];

    public function deviceGroups()
    {
        return $this->belongsToMany(DeviceGroup::class, 'device_group', 'group_id', 'device_id');
    }

    public function deviceGroup()
    {
        return $this->belongsTo(DeviceGroup::class, 'device_group_id');
    }

    public function devices()
    {
        return $this->belongsToMany(Device::class, 'device_group', 'group_id', 'device_id');
    }

}
