<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DevicePackage extends Model
{
    use HasFactory;
    protected $table = 'device_package';
    protected $fillable = [
        'device_id',
        'package_id'
    ];

    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }


}
