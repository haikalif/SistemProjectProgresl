<?php

use App\Http\Controllers\AuthController\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


route::get('/login', [AuthController::class, 'showLogin'])->name('login');
route::post('/login', [AuthController::class, 'login']);
route::post('/register', [AuthController::class, 'register'])->name('register');

route::middleware(['auth'])->group(function () {
    route::get('/dashboard', [AuthController::class, 'index'])->name('dashboard');
    route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
