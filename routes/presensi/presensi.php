<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Presensi\PresensiController;
use App\Http\Controllers\Presensi\AbsensiController;

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

Route::get('presensi', [PresensiController::class, 'index'])->name('presensi.index');
Route::post('store', [PresensiController::class, 'store'])->name('presensi.store');

Route::post('/ab',[AbsensiController::class,'store'])->name('test.absen');
    Route::post('/check-in', [PresensiController::class, 'checkIn'])->name('cekin');
    Route::post('/check-out', [PresensiController::class, 'checkOut'])->name('cekout');
    Route::get('/absensi' ,[PresensiController::class,'absen'])->name('absen');
