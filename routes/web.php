<?php

use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TdsCodeController;
use App\Http\Controllers\Admin\LetterContentController;

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
      
        //tds_code
        Route::get('/tds_code', [TdsCodeController::class, 'index'])->name('tds_code');
        Route::post('/tds_code/store', [TdsCodeController::class, 'store'])->name('tds_code.store');
        Route::post('/tds_code/bulk_operation', [TdsCodeController::class, 'bulk'])->name('tds_code.bulk');
        Route::get('tds_code/{id}/delete', [TdsCodeController::class, 'destroy'])->name('tds_code.delete');
        Route::get('tds_code/status/{id}', [TdsCodeController::class, 'toggleStatus'])->name('tds_code.status');

        //letter_content
        Route::get('/letter_content', [LetterContentController::class, 'index'])->name('letter_content');
        Route::get('letter_content/create', [LetterContentController::class, 'create'])->name('letter_content.create');
        Route::post('letter_content/create', [LetterContentController::class, 'store']);
        Route::get('letter_content/{id}/edit', [LetterContentController::class, 'edit'])->name('letter_content.edit');
        Route::post('letter_content/{id}/edit', [LetterContentController::class, 'update']);
        Route::post('letter_content/bulk_operation', [LetterContentController::class, 'bulk'])->name('letter_content.bulk');

    });
});
