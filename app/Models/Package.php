<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $table = 'packages';

    protected $fillable = [
        'name',
        'version',
        'file_path',
        'file_name',
    ];

    public function devices(){
        return $this->belongsToMany(Device::class, 'device_package', 'package_id', 'device_id');
    }

    public function devicePackages(){
        return $this->hasMany(DevicePackage::class, 'package_id');
    }
}
