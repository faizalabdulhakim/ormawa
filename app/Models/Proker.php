<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proker extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'tanggal_pelaksanaan',
        'deadline_proposal',
        'deadline_lpj',
        'status',
        'ormawa_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ormawa()
    {
        return $this->belongsTo(Ormawa::class);
    }
}
