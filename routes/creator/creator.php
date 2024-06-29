<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Creator\CreatorController;

Route::get('create_user',[CreatorController::class,'index'])->name('creator.index');
Route::get('delete_user/{id}',[CreatorController::class,'delete'])->name('creator.delete');
Route::get('restore_user/{id}',[CreatorController::class,'restore'])->name('creator.restore');
Route::post('create_new',[CreatorController::class,'create'])->name('creator.create');
Route::get('create_view/{id}',[CreatorController::class,'view'])->name('creator.view');
Route::post('create_edit',[CreatorController::class,'edit'])->name('creator.edit');
