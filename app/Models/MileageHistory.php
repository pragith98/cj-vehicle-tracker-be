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

class MileageHistory extends Model
{
    protected $table = 'mileage_histories';

    protected $primaryKey = null;

    public $incrementing = false;

    const UPDATED_AT = null;

    protected $fillable = [
        'vehicle_id',
        'mileage'
    ];
}