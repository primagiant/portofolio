<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembimbingAkademikController extends Controller
{
    public function index()
    {
        if (Auth::user()->hasRole('admin')) {
            return view('admin.pages.pembimbingAkademik');
        } else if (Auth::user()->hasRole('pembimbing_akademik')) {
            return view('pembimbing_akademik.pages.dashboard');
        }
    }
}
