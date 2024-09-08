<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'username',
        'nim',
        'password',
        'status',
        'ktm',
        'ormawa_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    public function ormawas() : BelongsToMany
    {
        return $this->belongsToMany(Ormawa::class)->withPivot('status', 'role');
    }

    public function ormawa()
    {
        return $this->belongsTo(Ormawa::class, 'ormawa_id');
    }

    public function roles()
    {
        return $this->hasMany(OrmawaUser::class);
    }

    public function statuses()
    {
        return $this->hasMany(OrmawaUser::class);
    }

    public function role()
    {
        $role = $this->roles()->where('ormawa_id', $this->ormawa_id)->first();

        if ($role) {
            return $role->role;
        }

        return null;
    }

    public function status()
    {
        $status = $this->statuses()->where('ormawa_id', $this->ormawa_id)->first();

        if ($status) {
            return $status->status;
        }

        return null;
    }
}
