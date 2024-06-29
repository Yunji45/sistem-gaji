<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DomPDF\DomPDFController;

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

Route::get('/view-pdf/{id}',[DomPDFController::class,'viewPDF'])->name('view-pdf');
Route::get('/download-pdf/{id}',[DomPDFController::class,'downloadPDF'])->name('download-pdf');
