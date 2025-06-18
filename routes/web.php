<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return \Inertia\Inertia::render('Index');
});


Route::get('/cache', []);

Route::prefix('app')->group(function () {
    Route::get('/menu', [\App\Http\Controllers\Web\WebMenuController::class, 'getMenuItems'])->name('app.menu');
});

Route::prefix('registry')->group(function () {
    Route::get('/files', [\App\Http\Controllers\Web\FileController::class, 'files'])->name('registry.files');
    Route::get('/services', [\App\Http\Controllers\Web\WebServiceController::class, 'services'])->name('registry.services');
});
