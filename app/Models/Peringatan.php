<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peringatan extends Model
{
    use HasFactory;

    // fillable
    protected $fillable = [
        'dokumen_id',
        'tipe',
        'peringatan',
        'user_id',
        'ormawa_id',
        'is_open',
    ];

    // relasi
    public function proposal()
    {
        return $this->belongsTo(Proposal::class, 'dokumen_id');
    }

    public function lpj()
    {
        return $this->belongsTo(Lpj::class, 'dokumen_id');
    }
}
