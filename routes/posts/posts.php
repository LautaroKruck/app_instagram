<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [PostController::class, 'showAll'])->name('posts.home'); 
    Route::get('/create', [PostController::class, 'show'])->name('posts.form');  
    Route::post('/create', [PostController::class, 'create'])->name('posts.create');
    Route::delete('/', [PostController::class, 'delete'])->name('posts.delete');
    Route::post('/', [PostController::class,'like'])->name('posts.like');
});



