<?php

use App\Http\Controllers\Web\AuthController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/cache', []);

Route::middleware('guest')->prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, function () {
        return Inertia::render('auth/Login');
    }])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('web.login');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/update-view-type', function () {
        \request()->validate(['view_type' => 'required|in:mis,registry']);

        session(['view_type' => \request()->view_type]); // Сохраняем в сессии
        return response()->json(['success' => true]);
    })->middleware('auth')->name('web.session.update-view-type');


    Route::get('/', function () {
        return \Inertia\Inertia::render('Index');
    })->name('index');

    Route::prefix('app')->group(function () {
        Route::get('/menu', [\App\Http\Controllers\Web\WebMenuController::class, 'getMenuItems'])->name('app.menu');
    });

    Route::prefix('registry')
        ->middleware(\App\Http\Middleware\EnsureViewType::class . ':registry')
        ->group(function () {
        Route::get('/registries', [\App\Http\Controllers\Web\FileController::class, 'registries'])->name('registry.registries');
        Route::get('/files', [\App\Http\Controllers\Web\FileController::class, 'files'])->name('registry.files');
        Route::prefix('services')->group(function () {
            Route::get('/', [\App\Http\Controllers\Web\WebServiceController::class, 'services'])->name('registry.services');
            Route::prefix('details')->group(function () {
                Route::get('/', [\App\Http\Controllers\Web\WebServiceController::class, 'details'])->name('registry.services.details');
            });
        });
    });

    Route::prefix('mis')
        ->middleware(\App\Http\Middleware\EnsureViewType::class . ':mis')
        ->group(function () {
        Route::get('/home', [\App\Http\Controllers\Web\Mis\StartController::class, 'home'])->name('mis.home');
        Route::prefix('services')->group(function () {
            Route::get('/', [\App\Http\Controllers\Web\Mis\ServiceController::class, 'services'])->name('mis.services');
            Route::prefix('details')->group(function () {
                Route::get('/', [\App\Http\Controllers\Web\Mis\ServiceController::class, 'details'])->name('mis.services.details');
            });
        });
    });

    Route::prefix('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('web.logout');
    });

    Route::prefix('libs')->group(function () {
        Route::prefix('services')->group(function () {
            Route::get('/', [\App\Http\Controllers\Web\LibServiceController::class, 'services'])->name('libs.index');
        });
    });
});

Route::get('/info', function () {
    return phpinfo();
});
