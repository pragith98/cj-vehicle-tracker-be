<?php

/*
 * @copyright (c) 2025 Pragith Lakshan Thilakarathna
 * All rights reserved. 
 * This code is proprietary to CJNextGenSys. 
 * Unauthorized use, reproduction, modification, distribution, or sale 
 * without the explicit written permission of CJNextGenSys is strictly prohibited.
 * For inquiries, please contact: [info@cjnextgensys.com]
*/

use App\Http\Controllers\MileageTrackerController;
use App\Http\Middleware\AuthenticateWithSanctumCookie;
use Illuminate\Support\Facades\Route;

// Route::middleware(AuthenticateWithSanctumCookie::class)
Route::prefix('mileage-trackers')
  ->group(function () {
    Route::get('/', [MileageTrackerController::class, 'index']);
    Route::get('/get-paginated', [MileageTrackerController::class, 'getPaginated']);
    Route::post('/', [MileageTrackerController::class, 'store']);
    Route::get('/{id}', [MileageTrackerController::class, 'show']);
    Route::put('/{id}', [MileageTrackerController::class, 'update']);
    Route::delete('/{id}', [MileageTrackerController::class, 'destroy']);
    Route::get('/{id}/is-deletable', [MileageTrackerController::class, 'isDeletable']);
    Route::put('/{id}/generate-key', [MileageTrackerController::class, 'generateKey']);
});