<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'device_owner'
    ];

    public function deviceState()
    {
        return $this->hasMany(DeviceState::class);
    }

    public function latestDeviceState()
    {
        return $this->hasOne(DeviceState::class)->latest('created_at');
    }

    public function hardware()
    {
        return $this->hasOne(Hardware::class);
    }

    public function allSoftware()
    {
        return $this->belongsToMany(AllSoftware::class, 'device_software', 'device_id', 'all_software_id');
    }

    public function deviceSoftware()
    {
        return $this->hasMany(DeviceSoftware::class);
    }

    public function deviceGroup()
    {
        return $this->belongsTo(DeviceGroup::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'device_group', 'device_id', 'group_id');
    }

    public function packages()
    {
        return $this->belongsToMany(Package::class,'device_package', 'package_id', 'device_id');
    }

    public function devicePackage()
    {
        return $this->hasMany(DevicePackage::class);
    }

}
