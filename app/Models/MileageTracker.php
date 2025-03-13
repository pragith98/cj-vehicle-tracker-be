<?php

/*
 * @copyright (c) 2025 Pragith Lakshan Thilakarathna
 * All rights reserved. 
 * This code is proprietary to CJNextGenSys. 
 * Unauthorized use, reproduction, modification, distribution, or sale 
 * without the explicit written permission of CJNextGenSys is strictly prohibited.
 * For inquiries, please contact: [info@cjnextgensys.com]
*/

namespace App\Models;

use App\Enums\MileageTrackerStatus;
use Illuminate\Database\Eloquent\Model;

class MileageTracker extends Model
{
    protected $table = 'mileage_trackers';

    protected $fillable = [
        'serial_no'
    ];

    public $timestamps = true;
    
    public $casts = [
        'status' => MileageTrackerStatus::class
    ];
}