<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;
    protected $table = "tb_jurusan";
    protected $fillable = [
        'nama_jurusan',
        'deskripsi',
        'fakultas_id',
    ];

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, 'fakultas_id', 'id');
    }

    public function prodi()
    {
        return $this->hasMany(Prodi::class, 'jurusan_id', 'id');
    }
}
