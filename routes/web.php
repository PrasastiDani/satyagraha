<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::get('/kamar', function () {
    return Inertia::render('Kamar');
})->name('kamar');

Route::get('/meetingballroom', function () {
    return Inertia::render('Meetingballroom');
})->name('meetingballroom');

Route::get('/fasilitas', function () {
    return Inertia::render('Fasilitas');
})->name('fasilitas');

Route::get('/galeri', function () {
    return Inertia::render('Galeri');
})->name('galeri');

Route::get('/kontak', function () {
    return Inertia::render('Kontak');
})->name('kontak');

Route::prefix('admin')->middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])
        ->name('admin.login');

    Route::post('/login', [LoginController::class, 'store'])
        ->name('admin.login.store');
});

// Grup Dashboard Admin (Hanya bisa diakses setelah login)
Route::middleware(['auth'])->group(function () {


    // Tambahkan rute management konten di sini nanti, contoh:
    // Route::resource('admin/kamar', KamarController::class);

    Route::post('/admin/logout', [LoginController::class, 'destroy'])->name('logout');
});


Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {
        Route::get('/dashboard', function () {
            return Inertia::render('Admin/Dashboard');
        })->name('dashboard');
    });
