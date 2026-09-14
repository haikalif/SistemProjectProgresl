<?php

use App\Http\Controllers\AuthController\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


route::get('/login', [AuthController::class, 'showLogin'])->name('login');
route::post('/login', [AuthController::class, 'login']);
route::get('/register', [AuthController::class, 'showRegister'])->name('register');
route::post('/register', [AuthController::class, 'register']);

route::middleware(['auth'])->group(function () {
    route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Placeholder routes untuk sidebar (Bagian & Level)
    route::get('/bagian', function() { return 'Halaman Bagian belum dibuat'; })->name('bagian.index');
    route::get('/level', function() { return 'Halaman Level belum dibuat'; })->name('level.index');
});
