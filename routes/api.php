<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('registry')->group(function () {
    Route::post('/parse', [\App\Http\Controllers\RegistryController::class, 'prepare'])->name('registry.parse');

    Route::get('/files', [\App\Http\Controllers\Api\Registry\FileController::class, 'files'])->name('api.registry.files');

    Route::post('/progress', [\App\Http\Controllers\Api\Registry\FileController::class, 'progress'])
        ->name('api.registry.progress')->middleware('guest');
});

Route::prefix('diagram')->group(function () {
    Route::prefix('usl')->group(function () {
        Route::get('count', [\App\Http\Controllers\Api\DiagramController::class, 'countUsls'])->name('api.diagram.usl.count');
        Route::get('single-count', [\App\Http\Controllers\Api\DiagramController::class, 'countSingleUsls'])->name('api.diagram.usl.single.count');
    });
    Route::prefix('mis')->group(function () {
        Route::prefix('stationar')->group(function () {
            Route::prefix('usl')->group(function () {
                Route::get('count', [\App\Http\Controllers\Api\DiagramController::class, 'countUslsInStationarMis'])->name('api.mis.diagram.stationar.usl.count');
            });
        });
        Route::prefix('polyclinic')->group(function () {
            Route::prefix('usl')->group(function () {
                Route::get('count', [\App\Http\Controllers\Api\DiagramController::class, 'countUslsInPolyclinicMis'])->name('api.mis.diagram.polyclinic.usl.count');
            });
        });
    });
});

Route::prefix('library')->group(function () {
    Route::post('import', [\App\Http\Controllers\Api\Library\UploadController::class, 'upload'])->name('api.library.upload');
});
