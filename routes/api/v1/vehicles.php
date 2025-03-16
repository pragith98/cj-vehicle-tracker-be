<?php

/*
 * @copyright (c) 2025 Pragith Lakshan Thilakarathna
 * All rights reserved. 
 * This code is proprietary to CJNextGenSys. 
 * Unauthorized use, reproduction, modification, distribution, or sale 
 * without the explicit written permission of CJNextGenSys is strictly prohibited.
 * For inquiries, please contact: [info@cjnextgensys.com]
*/

use App\Http\Controllers\VehicleController;
use App\Http\Middleware\AuthenticateWithSanctumCookie;
use Illuminate\Support\Facades\Route;

Route::middleware(AuthenticateWithSanctumCookie::class)
  ->prefix('vehicles')
  ->group(function () {
    Route::get('/', [VehicleController::class, 'index']);
    Route::get('/get-paginated', [VehicleController::class, 'getPaginated']);
    Route::post('/', [VehicleController::class, 'store']);
    Route::get('/{id}', [VehicleController::class, 'show']);
    Route::put('/{id}', [VehicleController::class, 'update']);
    Route::delete('/{id}', [VehicleController::class, 'destroy']);
    Route::get('/{id}/is-deletable', [VehicleController::class, 'isDeletable']);
});