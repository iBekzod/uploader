<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    Route::prefix('uploads')->group(function () {
        Route::post('findOne', [UploadController::class, 'show']);
        Route::post('findAll', [UploadController::class, 'index']);
        Route::post('create', [UploadController::class, 'store']);
        Route::post('update', [UploadController::class, 'update']);
        Route::post('remove', [UploadController::class, 'destroy']);
    });
});

Route::prefix('v2')->group(function () {
    Route::prefix('uploads')->group(function () {
        Route::get('/', [UploadController::class, 'index']);
        Route::post('/', [UploadController::class, 'store']);
        Route::get('/{id}', [UploadController::class, 'show']);
        Route::post('/{id}', [UploadController::class, 'update']);
        Route::delete('/{id}', [UploadController::class, 'destroy']);
    });
});
