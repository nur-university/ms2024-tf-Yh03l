<?php

use Illuminate\Support\Facades\Route;
use Commercial\Api\Controllers\ContractController;
use Commercial\Api\Controllers\UserController;
use Commercial\Api\Controllers\CatalogController;

Route::prefix('v1')->group(function () {
    // Rutas de Contratos
    Route::prefix('contracts')->group(function () {
        Route::post('/', [ContractController::class, 'create']);
        Route::get('/{id}', [ContractController::class, 'get']);
        Route::post('/{id}/activate', [ContractController::class, 'activate']);
        Route::post('/{id}/cancel', [ContractController::class, 'cancel']);
        Route::get('/by-paciente/{pacienteId}', [ContractController::class, 'getByPaciente']);
    });

    // Rutas de Usuarios
    Route::prefix('users')->group(function () {
        Route::post('/', [UserController::class, 'create']);
        Route::get('/by-email/{email}', [UserController::class, 'getByEmail']);
    });

    // Rutas de Catálogos
    Route::prefix('catalogs')->group(function () {
        Route::post('/', [CatalogController::class, 'create']);
        Route::get('/', [CatalogController::class, 'list']);
        Route::get('/{id}', [CatalogController::class, 'get']);
        Route::post('/{id}/services', [CatalogController::class, 'addService']);
        Route::delete('/{catalogId}/services/{serviceId}', [CatalogController::class, 'removeService']);
    });
}); 