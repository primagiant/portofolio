<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\KegiatanResource;
use App\Models\KategoriKegiatan;
use Symfony\Component\HttpFoundation\Response;

class KegiatanController extends Controller
{
    public function index()
    {
        return KegiatanResource::collection(
            KategoriKegiatan::where('nama', 'like', '%' . request('keyword') . "%")->paginate(5)
        );
    }

    public function show($id)
    {
        $kategori = new KegiatanResource(KategoriKegiatan::findOrFail($id));
        $response = [
            'message' => "Kegiatan with id " . $id,
            'data' => $kategori,
        ];
        return response()->json($response, Response::HTTP_OK);
    }
}
