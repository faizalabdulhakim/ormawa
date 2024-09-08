<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lpj extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'proposal_id',
        'cover',
        'kata_pengantar',
        'komentar_kata_pengantar',
        'latar_belakang',
        'komentar_latar_belakang',
        'nama',
        'komentar_nama',
        'tema',
        'komentar_tema',
        'tujuan',
        'komentar_tujuan',
        'sasaran',
        'komentar_sasaran',
        'konsep',
        'komentar_konsep',
        'waktu',
        'komentar_waktu',
        'kendala',
        'komentar_kendala',
        'susunan_kegiatan',
        'komentar_susunan_kegiatan',
        'susunan_kepanitiaan',
        'komentar_susunan_kepanitiaan',
        'rab',
        'komentar_rab',
        'penutup',
        'komentar_penutup',
        'bukti_transaksi',
        'komentar_bukti_transaksi',
        'dokumentasi',
        'komentar_dokumentasi',
        'isViewed',
        'proker_id',
        'user_id',
        'status',

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
