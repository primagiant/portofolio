<?php

use App\Http\Controllers\API\AngkatanController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\FakultasController;
use App\Http\Controllers\API\JenisKegiatanController;
use App\Http\Controllers\API\JurusanController;
use App\Http\Controllers\API\KategoriKegiatanController;
use App\Http\Controllers\API\KegiatanController;
use App\Http\Controllers\API\MahasiswaController;
use App\Http\Controllers\API\ProdiController;
use App\Http\Controllers\API\PembimbingAkademikController;
use App\Http\Controllers\API\PortofolioController;
use Illuminate\Support\Facades\Route;

// Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    // Kegiatan
    Route::resource('kegiatan', KegiatanController::class)->only(['index', 'show']);
    Route::resource('jeniskegiatan', JenisKegiatanController::class)->only(['index', 'show']);
    Route::resource('kategorikegiatan', KategoriKegiatanController::class)->only(['index', 'show']);
    // Pembimbing Akademik
    Route::resource('/pembimbingakademik', PembimbingAkademikController::class)->except(['create', 'edit']);
    Route::prefix('pembimbingakademik')->group(function () {
        Route::get('validMahasiswa', [PembimbingAkademikController::class, 'validMahasiswa']);
        Route::get('invalidMahasiswa', [PembimbingAkademikController::class, 'invalidMahasiswa']);
    });
    // Mahasiswa
    Route::resource('/mahasiswa', MahasiswaController::class)->except(['create', 'edit']);
    Route::prefix('mahasiswa')->group(function () {
        Route::post('assign/{id}', [MahasiswaController::class, 'assignMahasiswa']);
        Route::get('topMahasiswa/{angkatan_id}', [MahasiswaController::class, 'topMahasiswa']);
    });
    // Portofolio
    Route::resource('/portofolio', PortofolioController::class)->only(['index', 'store']);
    Route::prefix('portofolio')->group(function () {
        Route::delete('{id}', [PortofolioController::class, 'destroy']);
        Route::get('{id}', [PortofolioController::class, 'show']);
        Route::post('{portofolio}', [PortofolioController::class, 'update']);
        Route::post('validasi/{portofolio}', [PortofolioController::class, 'validasi']);
        Route::get('byNim/{nim}', [PortofolioController::class, 'byNim']);
        Route::get('countPortofolio', [PortofolioController::class, 'countPortofolio']);
    });
    Route::get('countPortofolio', [PortofolioController::class, 'countPortofolio']);
    // Fakultas
    Route::resource('/fakultas', FakultasController::class)->except(['create', 'edit']);
    Route::prefix('fakultas')->group(function () {
        Route::get('all', [FakultasController::class, 'allData']);
    });
    // Jurusan
    Route::resource('/jurusan', JurusanController::class)->except(['create', 'edit']);
    Route::prefix('jurusan')->group(function () {
        Route::get('byFakultas/{fakultas_id}', [JurusanController::class, 'byFakultas']);
    });
    // Prodi
    Route::resource('/prodi', ProdiController::class)->except(['create', 'edit']);
    Route::prefix('prodi')->group(function () {
        Route::get('byJurusan/{jurusan_id}', [ProdiController::class, 'byJurusan']);
    });
    // Angkatan
    Route::resource('angkatan', AngkatanController::class)->except(['create', 'edit']);
});
