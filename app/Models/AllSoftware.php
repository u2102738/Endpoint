<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllSoftware extends Model
{
    use HasFactory;

    protected $table = 'all_software';
    protected $fillable = [
        'name',
        'version',
        'type',
        'restriction'
    ];

    public function deviceSoftware()
    {
        return $this->hasMany(DeviceSoftware::class);
    }
}

