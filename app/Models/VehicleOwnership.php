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
use Illuminate\Support\Facades\Auth;

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

    public function owner()
    {
        return $this->belongsTo(VehicleOwner::class, 'vehicle_owner_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    protected static function boot()
    {
        parent::boot();

        // Set created_by and updated_by when creating a new model
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by = Auth::id();
                $model->updated_by = Auth::id();
            }
        });

        // Set updated_by when updating an existing model
        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::id();
            }
        });
    }
}