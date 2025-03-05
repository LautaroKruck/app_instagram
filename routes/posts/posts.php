<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [PostController::class, 'showAll'])->name('posts.home'); 
    Route::get('/', [PostController::class, 'show'])->name('posts.form');  
    Route::post('/', [PostController::class, 'create'])->name('posts.create');
    Route::delete('/{id}', [PostController::class, 'destroy'])->name('posts.delete');
});



