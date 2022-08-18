<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->hasRole('mahasiswa')) {
            return redirect('/mahasiswa/dashboard');
        } else if (Auth::user()->hasRole('pembimbingakademik')) {
            return redirect('/pembimbing-akademik/dashboard');
        } else if (Auth::user()->hasRole('admin')) {
            return redirect('/admin/dashboard');
        }
    }
}
