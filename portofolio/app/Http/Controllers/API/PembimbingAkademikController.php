<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\MahasiswaResource;
use App\Http\Resources\PembimbingAkademikResource;
use App\Models\Mahasiswa;
use App\Models\PembimbingAkademik;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\Rules;

class PembimbingAkademikController extends Controller
{
    public function index()
    {
        if (Auth::user()->hasRole('admin')) {
            return PembimbingAkademikResource::collection(
                PembimbingAkademik::paginate(5)
            );
        } else if (Auth::user()->hasRole('pembimbingakademik')) {
            return new PembimbingAkademikResource(
                PembimbingAkademik::where('user_id', Auth::user()->id)->first()
            );
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'fakultas_id' => ['required'],
            'jurusan_id' => ['required'],
            'prodi_id' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $user->attachRole('pembimbingakademik');
            event(new Registered($user));

            $pa = PembimbingAkademik::create([
                'nama' => $user->name,
                'user_id' => $user->id,
                'fakultas_id' => $request->fakultas_id,
                'jurusan_id' => $request->jurusan_id,
                'prodi_id' => $request->prodi_id,
            ]);

            DB::commit();

            $result = new PembimbingAkademikResource(
                PembimbingAkademik::findOrFail($pa->id)
            );

            $response = [
                'message' => "Pembimbing Akademik Data created",
                'data' => $result,
            ];
            return response()->json($response, Response::HTTP_CREATED);
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json([
                'message' => "Failed " . $e->errorInfo,
            ]);
        }
    }

    public function show($id)
    {
        $pembimbingAkademik = new PembimbingAkademikResource(PembimbingAkademik::findOrFail($id));
        $response = [
            'message' => "Pembimbing Akademik with id " . $id,
            'data' => $pembimbingAkademik,
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $pa = PembimbingAkademik::findOrFail($id);
        try {
            User::destroy($pa->user_id);
            $pa->delete();
            $response = [
                'message' => "Pembimbing Akademik Deleted",
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed " . $e->errorInfo,
            ]);
        }
    }

    public function validMahasiswa()
    {
        $pa_id = Auth::user()->pa->id;
        return MahasiswaResource::collection(
            Mahasiswa::whereHas('portofolio', function ($query) {
                $query->where('status', '=', "1");
            })->whereHas('pembimbing_akademik', function ($query) use ($pa_id) {
                $query->where('id', '=', $pa_id);
            })->paginate(7)
        );
    }

    public function invalidMahasiswa()
    {
        $pa_id = Auth::user()->pa->id;
        dd($pa_id);
        return MahasiswaResource::collection(
            Mahasiswa::whereHas('portofolio', function ($query) {
                $query->where('status', '=', "0");
            })->whereHas('pembimbing_akademik', function ($query) use ($pa_id) {
                $query->where('id', '=', $pa_id);
            })->paginate(7)
        );
    }
}
