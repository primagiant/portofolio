<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\JenisKegiatanResource;
use App\Models\JenisKegiatan;
use Illuminate\Http\Request;

class JenisKegiatanController extends Controller
{
    public function index()
    {
        return JenisKegiatanResource::collection(JenisKegiatan::all());
    }

    public function show($id)
    {
        return new JenisKegiatanResource(JenisKegiatan::findOrFail($id));
    }
}
