<?php

use Illuminate\Support\Facades\Route;
use Modules\Seguranca\Http\Controllers;

Route::prefix('seguranca')->name('seguranca::')->group(function () {

    Route::middleware(['auth', 'verified'])->group(function () {
        Route::resource('sistemas', Controllers\SistemasController::class);
        Route::resource('modulos', Controllers\ModulosController::class);
        Route::resource('funcionalidades', Controllers\FuncionalidadesController::class);
        Route::resource('privilegios', Controllers\PrivilegiosController::class);
        Route::resource('papeis', Controllers\PapeisController::class);

        Route::prefix('privilegios')->name('privilegios.')->group( function(){
            Route::delete('/destroydep/{dependencia}', [Controllers\PrivilegiosController::class, 'destroyDep'])->name('destroydep');
        });
    });
});