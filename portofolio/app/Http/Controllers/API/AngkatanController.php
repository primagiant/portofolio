<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AngkatanResource;
use App\Models\Angkatan;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AngkatanController extends Controller
{
    public function index(Request $request)
    {
        if (isset($request->page)) {
            return AngkatanResource::collection(Angkatan::orderBy('tahun', 'desc')->paginate(3));
        } else {
            return AngkatanResource::collection(Angkatan::orderBy('tahun', 'desc')->get());
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tahun' => 'required|numeric|digits:4',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $angkatan =  Angkatan::create($request->all());
            $response = [
                'message' => "Angkatan Data created",
                'data' => $angkatan,
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
        $angkatan = Angkatan::findOrFail($id);
        $response = [
            'message' => "Angkatan with id " . $id,
            'data' => $angkatan,
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        $angkatan = Angkatan::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'tahun' => 'required|numeric|digits:4',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $angkatan->update($request->all());
            $response = [
                'message' => "Angkatan Updated",
                'data' => $angkatan,
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
        $angkatan = Angkatan::findOrFail($id);
        try {
            $angkatan->delete();
            $response = [
                'message' => "Angkatan Deleted",
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed " . $e->errorInfo,
            ]);
        }
    }
}
