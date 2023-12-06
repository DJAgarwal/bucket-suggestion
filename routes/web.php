<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [App\Http\Controllers\BucketSuggestionController::class, 'index']);
Route::get('/index', [App\Http\Controllers\BucketSuggestionController::class, 'index'])->name('index');
Route::get('/bucket/create', [App\Http\Controllers\BucketController::class, 'create'])->name('buckets.create');
Route::post('/bucket/store', [App\Http\Controllers\BucketController::class, 'store'])->name('buckets.store');
Route::get('/ball/create', [App\Http\Controllers\BallController::class, 'create'])->name('balls.create');
Route::post('/ball/store', [App\Http\Controllers\BallController::class, 'store'])->name('balls.store');
Route::post('/ball-suggestion/store', [App\Http\Controllers\BucketSuggestionController::class, 'store'])->name('ball-suggestion.store');