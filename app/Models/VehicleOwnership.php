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

use Illuminate\Database\Eloquent\Model;

class VehicleOwnership extends Model
{
    protected $table = 'vehicle_ownerships';

    protected $primaryKey = null;

    public $incrementing = false;

    protected $fillable = [
        'vehicle_id',
        'vehicle_owner_id',
        'start_date',
        'end_date'
    ];
}