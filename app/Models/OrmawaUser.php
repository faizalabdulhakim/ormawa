<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrmawaUser extends Model
{
    use HasFactory;

    // table name
    protected $table = 'ormawa_user';
    
    // fillable
    protected $fillable = [
        'ormawa_id',
        'user_id',
        'role',
        'status'
    ];
    
}
