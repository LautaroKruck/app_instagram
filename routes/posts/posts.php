<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// RUTA PARA ENRUTAR /posts/
Route::get('/', [PostController::class, 'showPosts'])->name('home');
Route::get('/register', [PostController::class, 'showRegister'])->name('register');

Route::post('/login', [PostController::class, 'doLogin'])->name('user.doLogin');
Route::post('/register', [PostController::class, 'doRegister'])->name('user.doRegister');

Route::middleware(['auth'])->group(function () {
    Route::get('/perfil/{id}', [PostController::class, 'showUser'])->name('user.show');
    
    Route::get('/rutaProtegida', function() {
        return view('viewProtegida');
    });
});

