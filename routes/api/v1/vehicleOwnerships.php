<?php

/*
 * @copyright (c) 2025 Pragith Lakshan Thilakarathna
 * All rights reserved. 
 * This code is proprietary to CJNextGenSys. 
 * Unauthorized use, reproduction, modification, distribution, or sale 
 * without the explicit written permission of CJNextGenSys is strictly prohibited.
 * For inquiries, please contact: [info@cjnextgensys.com]
*/

use App\Http\Controllers\VehicleOwnershipController;
use Illuminate\Support\Facades\Route;

Route::prefix('vehicle-ownerships')->group(function () {
  Route::get('/', [VehicleOwnershipController::class, 'index']);
  Route::get('/get-paginated', [VehicleOwnershipController::class, 'getPaginated']);
  Route::post('/', [VehicleOwnershipController::class, 'store']);
  Route::get('/{vehicleId}/{ownerId}/{startDate}', [VehicleOwnershipController::class, 'show']);
  Route::put('/{vehicleId}/{ownerId}/{startDate}', [VehicleOwnershipController::class, 'update']);
  Route::delete('/{vehicleId}/{ownerId}/{startDate}', [VehicleOwnershipController::class, 'destroy']);
});