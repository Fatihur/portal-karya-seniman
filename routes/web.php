<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\KaryaController;
use App\Http\Controllers\Public\SenimanController;
use App\Http\Controllers\Public\KategoriController as PublicKategoriController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\SenimanController as AdminSenimanController;
use App\Http\Controllers\Admin\KaryaSeniController as AdminKaryaSeniController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\KataSambutanController;
use App\Http\Controllers\Seniman\DashboardController as SenimanDashboardController;
use App\Http\Controllers\Seniman\KaryaSeniController as SenimanKaryaSeniController;
use App\Http\Controllers\Seniman\ProfilController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Karya Publik
Route::get('/karya', [KaryaController::class, 'index'])->name('karya.index');
Route::get('/karya/{slug}', [KaryaController::class, 'show'])->name('karya.show');

// Seniman Publik
Route::get('/seniman', [SenimanController::class, 'index'])->name('seniman.index');
Route::get('/seniman/{id}', [SenimanController::class, 'show'])->name('seniman.show');

// Kategori
Route::get('/kategori', [PublicKategoriController::class, 'index'])->name('kategori.index');
Route::get('/kategori/{slug}', [PublicKategoriController::class, 'show'])->name('kategori.show');

// Halaman Statis
Route::get('/kata-sambutan', [HomeController::class, 'kataSambutan'])->name('kata-sambutan');
Route::get('/pencarian', [HomeController::class, 'pencarian'])->name('pencarian');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['guest'])->group(function () {
    // Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    // Register
    Route::get('/registrasi', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/registrasi', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    // All admin routes require 'admin' role
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Kategori
    Route::resource('kategori', KategoriController::class);
    
    // Seniman
    Route::get('/seniman', [AdminSenimanController::class, 'index'])->name('seniman.index');
    Route::get('/seniman/{user}', [AdminSenimanController::class, 'show'])->name('seniman.show');
    Route::put('/seniman/{user}/status', [AdminSenimanController::class, 'updateStatus'])->name('seniman.update-status');
    Route::put('/seniman/{user}/reset-password', [AdminSenimanController::class, 'resetPassword'])->name('seniman.reset-password');
    
    // Karya Seni
    Route::get('/karya', [AdminKaryaSeniController::class, 'index'])->name('karya.index');
    Route::get('/karya/{karyaSeni}', [AdminKaryaSeniController::class, 'show'])->name('karya.show');
    Route::get('/karya/{karyaSeni}/review', [AdminKaryaSeniController::class, 'review'])->name('karya.review');
    Route::post('/karya/{karyaSeni}/review', [AdminKaryaSeniController::class, 'submitReview'])->name('karya.submit-review');
    Route::delete('/karya/{karyaSeni}', [AdminKaryaSeniController::class, 'destroy'])->name('karya.destroy');
    
    // Slider
    Route::resource('slider', SliderController::class);
    
    // Kata Sambutan
    Route::resource('kata-sambutan', KataSambutanController::class);

});

/*
|--------------------------------------------------------------------------
| Seniman Routes
|--------------------------------------------------------------------------
*/

Route::prefix('dashboard-seniman')->middleware(['auth', 'role:seniman'])->name('seniman.')->group(function () {
    Route::get('/', [SenimanDashboardController::class, 'index'])->name('dashboard');
    
    // Profil
    Route::get('/profil', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');
    
    // Karya
    Route::get('/karya', [SenimanKaryaSeniController::class, 'index'])->name('karya.index');
    Route::get('/karya/create', [SenimanKaryaSeniController::class, 'create'])->name('karya.create');
    Route::post('/karya', [SenimanKaryaSeniController::class, 'store'])->name('karya.store');
    Route::get('/karya/{karyaSeni}/edit', [SenimanKaryaSeniController::class, 'edit'])->name('karya.edit');
    Route::put('/karya/{karyaSeni}', [SenimanKaryaSeniController::class, 'update'])->name('karya.update');
    Route::delete('/karya/{karyaSeni}', [SenimanKaryaSeniController::class, 'destroy'])->name('karya.destroy');
    Route::post('/karya/{karyaSeni}/ajukan', [SenimanKaryaSeniController::class, 'ajukan'])->name('karya.ajukan');
});
