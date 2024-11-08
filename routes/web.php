<?php

use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TdsCodeController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'authenticate']);

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('dashboard');
        
        //ffi UserMasters
        Route::get('/usermasters',[UserController::class,'index'])->name('usermasters');
        Route::get('usermasters/create',[UserController::class,'create'])->name('usermasters.create');
        
        //tds_code
        Route::get('/tds_code',[TdsCodeController::class,'index'])->name('tds_code');
        Route::post('/tdscode/store', [TdsCodeController::class, 'store'])->name('tds_code.store');

    });
});
