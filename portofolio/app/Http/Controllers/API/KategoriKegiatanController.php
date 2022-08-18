<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\KategoriKegiatanResource;
use App\Models\KategoriKegiatan;

class KategoriKegiatanController extends Controller
{
    public function index()
    {
        return KategoriKegiatanResource::collection(KategoriKegiatan::all());
    }

    public function show($id)
    {
        return new KategoriKegiatanResource(KategoriKegiatan::findOrFail($id));
    }
}
