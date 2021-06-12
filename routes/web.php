<?php

// use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\CheckController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UrlController;
use App\Http\Controllers\HomeController;

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

// Auth::routes();
Route::get('/', [HomeController::class, 'index'])->name('home');


Route::resources([
    'urls' => UrlController::class,
]);

Route::post('/urls/{id}/checks', [CheckController::class, 'store'])->name('check.store');
Route::get('/urls/{id}/checks', [CheckController::class, 'index']);
