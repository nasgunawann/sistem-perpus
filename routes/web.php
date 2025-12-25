<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Anggota\DashboardController as AnggotaDashboardController;

use Illuminate\Support\Facades\Auth;

// Landing Page
Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('anggota.dashboard');
    }

    return view('welcome');
});


// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'show'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('buku', \App\Http\Controllers\Admin\BukuController::class);
    Route::resource('kategori', \App\Http\Controllers\Admin\KategoriController::class)->except(['show']);
    Route::resource('anggota', \App\Http\Controllers\Admin\AnggotaController::class);
    Route::resource('peminjaman', \App\Http\Controllers\Admin\PeminjamanController::class)->only(['index', 'create', 'store', 'show']);
    Route::post('peminjaman/{peminjaman}/return', [\App\Http\Controllers\Admin\PeminjamanController::class, 'return'])->name('peminjaman.return');
    Route::resource('denda', \App\Http\Controllers\Admin\DendaController::class)->only(['index', 'show']);
    Route::post('denda/{denda}/pay', [\App\Http\Controllers\Admin\DendaController::class, 'pay'])->name('denda.pay');
    Route::get('pengaturan', [\App\Http\Controllers\Admin\PengaturanController::class, 'index'])->name('pengaturan');
    Route::put('pengaturan', [\App\Http\Controllers\Admin\PengaturanController::class, 'update'])->name('pengaturan.update');
    Route::get('profil', [\App\Http\Controllers\Admin\ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('profil', [\App\Http\Controllers\Admin\ProfilController::class, 'update'])->name('profil.update');
    Route::put('profil/password', [\App\Http\Controllers\Admin\ProfilController::class, 'updatePassword'])->name('profil.password');
});

// Anggota Routes
Route::middleware(['auth', 'role:anggota'])->prefix('anggota')->name('anggota.')->group(function () {
    Route::get('/dashboard', [AnggotaDashboardController::class, 'index'])->name('dashboard');
    Route::get('/katalog', [\App\Http\Controllers\Anggota\BukuController::class, 'index'])->name('katalog');
    Route::get('/katalog/{buku}', [\App\Http\Controllers\Anggota\BukuController::class, 'show'])->name('katalog.show');
    Route::get('/denda', [\App\Http\Controllers\Anggota\DendaController::class, 'index'])->name('denda');
    Route::get('/profil', [\App\Http\Controllers\Anggota\ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [\App\Http\Controllers\Anggota\ProfilController::class, 'update'])->name('profil.update');
    Route::put('/profil/password', [\App\Http\Controllers\Anggota\ProfilController::class, 'updatePassword'])->name('profil.password');
});
