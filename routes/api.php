<?php

use App\Http\Controllers\CompressFileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('compress')->name('compress.')->group(function () {
    Route::get('', function () {
        return 'water';
    });
    Route::post('upload', [CompressFileController::class, 'upload'])->name('upload');
    Route::get('download/{batchId}', [CompressFileController::class, 'download'])->name('download');
});
