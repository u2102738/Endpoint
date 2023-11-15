<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceSoftware extends Model
{
    use HasFactory;

    protected $table = 'device_software';
    protected $fillable = [
        'device_id',
        'all_software_id',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function allSoftware()
    {
        return $this->belongsTo(AllSoftware::class);
    }

}
