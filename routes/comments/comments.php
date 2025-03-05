<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/', [CommentController::class, 'show'])->name('comments');
    Route::post('/', [CommentController::class, 'create'])->name('comments.create');
});