<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipe',
        'dokumen_id',
        'is_open',
        'bagian',
        'user_id',
        'ormawa_id',
    ];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class, 'dokumen_id');
    }

    public function lpj()
    {
        return $this->belongsTo(Lpj::class, 'dokumen_id');
    }
}
