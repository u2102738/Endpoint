<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hardware extends Model
{
    use HasFactory;

    protected $table = 'hardware';
    protected $fillable = [
        'device_id',
        'name',
        'OS_Version',
        'vendor',
        'serial_number',
        'domain',
        'system_family',
        'version',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
