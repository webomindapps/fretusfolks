<?php

use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TdsCodeController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'authenticate']);

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('dashboard');
        
        //ffi UserMasters
        Route::get('/usermasters',[UserController::class,'index'])->name('usermasters');
        Route::get('usermasters/create',[UserController::class,'create'])->name('usermasters.create');
        Route::post('usermasters/create',[UserController::class,'store']);
        Route::post('usermasters/bulkupdate',[UserController::class,'bulk'])->name('usermasters.bulk');
        Route::get('usermasters/{id}/edit',[UserController::class,'edit'])->name('usermasters.edit');
        Route::post('usermasters/{id}/edit',[UserController::class,'update']);
        Route::get('usermasters/{id}/delete',[UserController::class,'delete'])->name('usermasters.delete');
        
        //tds_code
        Route::get('/tds_code',[TdsCodeController::class,'index'])->name('tds_code');
        Route::post('/tdscode/store', [TdsCodeController::class, 'store'])->name('tds_code.store');

    });
});
