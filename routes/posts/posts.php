<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/', [PostController::class, 'showAll'])->name('posts.home'); 
    Route::get('/posts', [PostController::class, 'show'])->name('posts.form');  
    Route::post('/posts', [PostController::class, 'create'])->name('posts.create');
    Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
});



