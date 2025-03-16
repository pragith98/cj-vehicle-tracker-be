<?php

/*
 * @copyright (c) 2025 Pragith Lakshan Thilakarathna
 * All rights reserved. 
 * This code is proprietary to CJNextGenSys. 
 * Unauthorized use, reproduction, modification, distribution, or sale 
 * without the explicit written permission of CJNextGenSys is strictly prohibited.
 * For inquiries, please contact: [info@cjnextgensys.com]
*/

use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    require base_path('routes/api/v1/auth.php');
    require base_path('routes/api/v1/users.php');
    require base_path('routes/api/v1/mileageTrackers.php');
    require base_path('routes/api/v1/vehicles.php');
    require base_path('routes/api/v1/vehicleOwners.php');
    require base_path('routes/api/v1/vehicleOwnerships.php');
    require base_path('routes/api/v1/mileageHistories.php');
});