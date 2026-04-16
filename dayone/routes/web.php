<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;

Route::get('/', [HomeController::class, 'index']);

Route::get('posts/trashed', [PostController::class, 'trashed'])->name('posts.trashed');
Route::post('posts/{id}/restore', [PostController::class, 'restore'])->name('posts.restore');
Route::delete('posts/{id}/force', [PostController::class, 'forceDelete'])->name('posts.force-delete');
Route::resource('posts', PostController::class);
