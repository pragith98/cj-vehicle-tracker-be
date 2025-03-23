<?php

/*
 * @copyright (c) 2025 Pragith Lakshan Thilakarathna
 * All rights reserved. 
 * This code is proprietary to CJNextGenSys. 
 * Unauthorized use, reproduction, modification, distribution, or sale 
 * without the explicit written permission of CJNextGenSys is strictly prohibited.
 * For inquiries, please contact: [info@cjnextgensys.com]
*/

use App\Http\Controllers\VehicleOwnerController;
use App\Http\Middleware\AuthenticateWithSanctumCookie;
use Illuminate\Support\Facades\Route;

// Route::middleware(AuthenticateWithSanctumCookie::class)
Route::prefix('vehicle-owners')
  ->group(function () {
    Route::get('/', [VehicleOwnerController::class, 'index']);
    Route::get('/get-paginated', [VehicleOwnerController::class, 'getPaginated']);
    Route::post('/', [VehicleOwnerController::class, 'store']);
    Route::get('/{id}', [VehicleOwnerController::class, 'show']);
    Route::put('/{id}', [VehicleOwnerController::class, 'update']);
    Route::delete('/{id}', [VehicleOwnerController::class, 'destroy']);
    Route::get('/{id}/is-deletable', [VehicleOwnerController::class, 'isDeletable']);
});