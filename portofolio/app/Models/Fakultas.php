<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    use HasFactory;
    protected $table = "tb_fakultas";
    protected $fillable = [
        'nama_fakultas',
        'deskripsi'
    ];

    public function jurusan()
    {
        return $this->hasMany(Jurusan::class, 'fakultas_id', 'id');
    }

    public function prodi()
    {
        return $this->hasMany(Prodi::class, 'fakultas_id', 'id');
    }
}
