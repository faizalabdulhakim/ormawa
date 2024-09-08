<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'status',
        'cover',
        'proker_id',
        'ketua_pelaksana',
        'nim_ketua_pelaksana',
        'ketua_jurusan',
        'nip_ketua_jurusan',
        'user_id',
        'nama',
        'komentar_nama',
        'tema',
        'komentar_tema',
        'latar_belakang',
        'komentar_latar_belakang',
        'tujuan',
        'komentar_tujuan',
        'target',
        'komentar_target',
        'konsep',
        'komentar_konsep',
        'waktu',
        'komentar_waktu',
        'susunan_kegiatan',
        'komentar_susunan_kegiatan',
        'susunan_kepanitiaan',
        'komentar_susunan_kepanitiaan',
        'rab',
        'komentar_rab',
        'penutup', 
        'komentar_penutup', 
        'komentar',
        'isViewed'
    ];

    public function proker()
    {
        return $this->belongsTo(Proker::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
