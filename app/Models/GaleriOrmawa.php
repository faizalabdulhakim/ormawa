<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GaleriOrmawa extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipe',
        'nama_file',
        'ormawa_id',
    ];
}
