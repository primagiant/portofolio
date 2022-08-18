<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\JurusanResource;
use App\Models\Fakultas;
use App\Models\Jurusan;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class JurusanController extends Controller
{
    public function index(Request $request)
    {
        if (isset($request->page)) {
            $jurusan = JurusanResource::collection(Jurusan::paginate(4));
            $response = [
                'message' => "All Data Jurusan",
                'data' => $jurusan,
            ];
            return response()->json($response, Response::HTTP_OK);
        } else {
            return JurusanResource::collection(Jurusan::all());
        }
    }

    public function byFakultas($fakultas_id)
    {
        return JurusanResource::collection(Fakultas::find($fakultas_id)->jurusan);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_jurusan' => 'required|string|max:191',
            'deskripsi' => 'required|string|max:191',
            'fakultas_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $jurusan =  Jurusan::create($request->all());
            $response = [
                'message' => "Jurusan Data created",
                'data' => $jurusan,
            ];
            return response()->json($response, Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed " . $e->errorInfo,
            ]);
        }
    }

    public function show($id)
    {
        $jurusan = new JurusanResource(Jurusan::findOrFail($id));
        $response = [
            'message' => "Jurusan with id " . $id,
            'data' => $jurusan,
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        $jurusan = Jurusan::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'nama_jurusan' => 'required|string|max:191',
            'deskripsi' => 'required|string|max:191',
            'fakultas_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $jurusan->update($request->all());
            $response = [
                'message' => "Jurusan Updated",
                'data' => $jurusan,
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed " . $e->errorInfo,
            ]);
        }
    }

    public function destroy($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        try {
            $jurusan->delete();
            $response = [
                'message' => "Jurusan Deleted",
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed " . $e->errorInfo,
            ]);
        }
    }
}
