<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsfeedController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/newsfeed', [NewsfeedController::class, 'index'])->name('newsfeed.index');
Route::post('/posts', [NewsfeedController::class, 'store'])->name('posts.store');
Route::delete('/posts/{post}', [NewsfeedController::class, 'destroy'])->name('posts.destroy');
Route::post('/posts/{post}/comments', [NewsfeedController::class, 'storeComment'])->name('comments.store');
Route::delete('/comments/{comment}', [NewsfeedController::class, 'destroyComment'])->name('comments.destroy');
