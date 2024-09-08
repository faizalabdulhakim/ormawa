<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ormawa extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo',
        'nama',
        'angkatan',
        'jenis',
        'deskripsi',
        'jurusan',
        'ketua_id',
        'sekretaris_umum_id',
        'pembina_id',
        'cover',
        'kata_pengantar',
        'bab1',
        'bab2',
        'bab3',
        'laporan_admin',
        'laporan_keuangan',
        'ketua_jurusan',
        'nip_ketua_jurusan',
        'bukti_transaksi',
        'dokumentasi',
    ];

    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function ketua()
    {
        return $this->belongsTo(User::class, 'ketua_id');
    }

    public function pembina()
    {
        return $this->belongsTo(User::class, 'pembina_id');
    }

    public function sekretarisUmum()
    {
        return $this->belongsTo(User::class, 'sekretaris_umum_id');
    }

    public function galeri()
    {
        return $this->hasMany(GaleriOrmawa::class);
    }

    public function prestasi()
    {
        return $this->hasMany(PrestasiOrmawa::class);
    }

    public function proker_count()
    {
        return $this->hasMany(Proker::class)->count();
    }
}
