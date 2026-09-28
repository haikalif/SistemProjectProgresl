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

    // route untuk sidebar (Bagian & Level)
    Route::get('/bagian', function () {
        return view('components.bagian.index');
    })->name('bagian.index');

    // route untuk sidebar (Bagian & Level)
    Route::get('/level', function () {
        return view('level.index');
    })->name('level.index');
});
