<?php

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

// Halaman Login Admin (Hanya diakses via address bar)
Route::get('/admin', function () {
    return Inertia::render('Admin/Login');
})->name('login');

// Proses Login
Route::post('/admin/login', [App\Http\Controllers\Auth\LoginController::class, 'store'])->name('login.post');

// Grup Dashboard Admin (Hanya bisa diakses setelah login)
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return Inertia::render('Admin/Dashboard');
    })->name('admin.dashboard');

    // Tambahkan rute management konten di sini nanti, contoh:
    // Route::resource('admin/kamar', KamarController::class);

    Route::post('/admin/logout', [App\Http\Controllers\Auth\LoginController::class, 'destroy'])->name('logout');
});
