<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;
    protected $table = "tb_mahasiswa";
    protected $fillable = [
        'nim',
        'nama',
        'user_id',
        'pembimbing_akademik_id',
        'angkatan_id',
        'fakultas_id',
        'jurusan_id',
        'prodi_id',
        'status',
    ];

    public function portofolio()
    {
        return $this->hasMany(Portofolio::class, 'mahasiswa_id', 'id');
    }

    public function account()
    {
        return $this->hasOne(User::class);
    }

    public function pembimbing_akademik()
    {
        return $this->belongsTo(PembimbingAkademik::class, 'pembimbing_akademik_id', 'id');
    }

    public function angkatan()
    {
        return $this->belongsTo(Angkatan::class, 'angkatan_id', 'id');
    }

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, 'fakultas_id', 'id');
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id', 'id');
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id', 'id');
    }
}
