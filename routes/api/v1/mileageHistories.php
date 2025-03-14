<?php

/*
 * @copyright (c) 2025 Pragith Lakshan Thilakarathna
 * All rights reserved. 
 * This code is proprietary to CJNextGenSys. 
 * Unauthorized use, reproduction, modification, distribution, or sale 
 * without the explicit written permission of CJNextGenSys is strictly prohibited.
 * For inquiries, please contact: [info@cjnextgensys.com]
*/

use App\Http\Controllers\MileageHistoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('mileage-histories')->group(function () {
  Route::get('/', [MileageHistoryController::class, 'index']);
  Route::get('/get-paginated', [MileageHistoryController::class, 'getPaginated']);
  Route::post('/', [MileageHistoryController::class, 'store']);
  Route::delete('/{vehicleId}/{createdAt}', [MileageHistoryController::class, 'destroy']);
});