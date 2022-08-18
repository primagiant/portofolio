<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MahasiswaController extends Controller
{
    public function index()
    {
        if (Auth::user()->hasRole('admin')) {
            $mahasiswa = Mahasiswa::orderBy('nim')->paginate(5);
            return view('admin.pages.mahasiswa', compact('mahasiswa'));
        } else if (Auth::user()->hasRole('pembimbing_akademik')) {
            return view('pembimbing_akademik.pages.dashboard');
        } else if (Auth::user()->hasRole('mahasiswa')) {
            return view('mahasiswa.pages.dashboard');
        }
    }
}
