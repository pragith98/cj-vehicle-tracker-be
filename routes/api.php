<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    require base_path('routes/api/v1/users.php');
    require base_path('routes/api/v1/mileageTrackers.php');
    require base_path('routes/api/v1/vehicles.php');
    require base_path('routes/api/v1/vehicleOwners.php');
});