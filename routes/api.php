<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('registry')->group(function () {
    Route::post('/parse', [\App\Http\Controllers\RegistryController::class, 'parse'])->name('registry.parse');

    Route::get('/files', [\App\Http\Controllers\Api\Registry\FileController::class, 'files'])->name('api.registry.files');
});
