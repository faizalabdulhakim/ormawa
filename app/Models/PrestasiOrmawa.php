<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrestasiOrmawa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'sertifikat',
        'ormawa_id',
    ];
}
