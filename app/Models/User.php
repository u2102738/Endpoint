<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
// use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens as SanctumHasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phonenumber',
        'role_id',
    ];

    protected $dates = [ 'deleted_at' ];

    public function runSoftDelete()
    {
        $query = $this->setKeysForSaveQuery($this->newQueryWithoutScopes());

        $time = $this->freshTimestamp();

        $columns = [$this->getDeletedAtColumn() => $this->fromDateTime($time)];

        // Nullify the other columns
        $columns['email'] = null;
        $columns['phonenumber'] = null;
        $columns['password'] = null;
        $columns['role_id'] = null;

        $query->update($columns);
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function hasPermission($permission)
    {
        if ($this->role->permission()->where('name', $permission)->exists()) {
            return true;
        }
        return false;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
