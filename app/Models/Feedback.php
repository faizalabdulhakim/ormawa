<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    //fillable
    protected $fillable = [
        'dokumen_id',
        'tipe',
        'status',
        'user_id',
        'ormawa_id',
        'feedback',
        'is_open',
    ];

    //relasi
    public function proposal()
    {
        return $this->belongsTo(Proposal::class, 'dokumen_id');
    }

    public function lpj()
    {
        return $this->belongsTo(Lpj::class, 'dokumen_id');
    }
}
