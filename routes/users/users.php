<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// RUTA PARA ENRUTAR /user/
Route::get('/login', [UserController::class, 'showLogin'])->name('login');
Route::get('/register', [UserController::class, 'showRegister'])->name('register');

Route::post('/login', [UserController::class, 'doLogin'])->name('user.doLogin');
Route::post('/register', [UserController::class, 'doRegister'])->name('user.doRegister');

Route::middleware(['auth'])->group(function () {
    Route::get('/perfil/{id}', [UserController::class, 'showUser'])->name('user.profile');
    
    Route::get('/logout', [UserController::class, 'logout'])->name('user.logout');

    Route::get('/rutaProtegida', function() {
        return view('viewProtegida');
    });
});