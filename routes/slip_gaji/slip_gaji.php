<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SlipGaji\SlipGajiController;

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

Route::get('slip_gaji',[SlipGajiController::class,'index'])->name('slip_gaji.index');
Route::post('storeKelolaSalary',[SlipGajiController::class,'storeKelolaSalary'])->name('slip_gaji.storeKelolaSalary');
Route::post('storeSetBulan',[SlipGajiController::class,'storeSetBulan'])->name('slip_gaji.storeSetBulan');
Route::post('gajiKaryawan',[SlipGajiController::class,'gajiKaryawan'])->name('slip_gaji.gajiKaryawan');
Route::get('resetGajiKaryawan/{id}',[SlipGajiController::class,'resetGajiKaryawan'])->name('slip_gaji.reset-gaji');
