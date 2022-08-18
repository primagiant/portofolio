<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\FakultasResource;
use App\Models\Fakultas;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class FakultasController extends Controller
{
    public function index(Request $request)
    {
        if (isset($request->page)) {
            $fakultas = FakultasResource::collection(Fakultas::paginate(4));
            $response = [
                'message' => "All Data Fakultas",
                'data' => $fakultas,
            ];
            return response()->json($response, Response::HTTP_OK);
        } else {
            return FakultasResource::collection(Fakultas::all());
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_fakultas' => 'required|string|max:191',
            'deskripsi' => 'required|string|max:191',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $fakultas =  Fakultas::create($request->all());
            $response = [
                'message' => "Fakultas data created",
                'data' => $fakultas,
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
        $fakultas = new FakultasResource(Fakultas::findOrFail($id));
        $response = [
            'message' => "Fakultas with id " . $id,
            'data' => $fakultas,
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        $fakultas = Fakultas::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'nama_fakultas' => 'required|string|max:191',
            'deskripsi' => 'required|string|max:191',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $fakultas->update($request->all());
            $response = [
                'message' => "Fakultas Updated",
                'data' => $fakultas,
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
        $fakultas = Fakultas::findOrFail($id);
        try {
            $fakultas->delete();
            $response = [
                'message' => "Fakultas Deleted",
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed " . $e->errorInfo,
            ]);
        }
    }
}
