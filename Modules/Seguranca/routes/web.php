<?php

use Illuminate\Support\Facades\Route;
use Modules\Seguranca\Http\Controllers\SistemasController;
use Modules\Seguranca\Models\Sistemas;

Route::prefix('seguranca')->name('seguranca::')->group(function () {

    Route::middleware(['auth', 'verified'])->group(function () {
        Route::resource('sistemas', SistemasController::class);
        
    });

});

