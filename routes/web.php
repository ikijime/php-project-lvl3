<?php

// use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UrlController;
use App\Http\Controllers\UrlCheckController;
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

Route::post('/urls/{id}/checks', [UrlCheckController::class, 'store'])->name('urls.checks.store');
Route::get('/urls/{id}/checks', [UrlCheckController::class, 'index'])->name('urls.checks.index');
