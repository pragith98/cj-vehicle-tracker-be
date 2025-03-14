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

use App\Enums\Salutation;
use Illuminate\Database\Eloquent\Model;

class VehicleOwner extends Model
{
    protected $table = 'vehicle_owners';

    protected $fillable = [
        'NIC',
        'telephone_no',
        'salutation',
        'name'
    ];

    protected $casts = [
        'salutation' => Salutation::class
    ];
}