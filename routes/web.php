<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::name('ads.')->group(function () {
    Route::get('/', [\App\Http\Controllers\AdController::class, 'index'])
        ->name('index');

    Route::get('/edit', [\App\Http\Controllers\AdController::class, 'create'])
        ->middleware('auth')
        ->name('create');

    Route::post('/', [\App\Http\Controllers\AdController::class, 'store'])
        ->middleware('auth')
        ->name('store');

    Route::get('/{ad}', [\App\Http\Controllers\AdController::class, 'show'])
        ->where('ad', '[0-9]+')
        ->name('show');

    Route::get('/edit/{ad}', [\App\Http\Controllers\AdController::class, 'edit'])
        ->middleware('can:update,ad')
        ->name('edit');

    Route::put('/{ad}', [\App\Http\Controllers\AdController::class, 'update'])
        ->middleware('can:update,ad')
        ->name('update');

    Route::delete('/delete/{ad}', [\App\Http\Controllers\AdController::class, 'destroy'])
        ->middleware('can:delete,ad')
        ->name('destroy');
});

Route::get('/login', fn() => redirect('/'));

Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])
    ->middleware('guest')
    ->name('login');

Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');
