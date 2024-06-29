<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProfilController;

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

Route::get('/', [AuthController::class,'login'])->name('login')->middleware('isLogged');
Route::post('authentication', [AuthController::class,'authentication'])->name('authentication');
Route::post('logout',[AuthController::class,'logout'])->name('logout');
Route::get('profil',[ProfilController::class,'index'])->name('profil');
