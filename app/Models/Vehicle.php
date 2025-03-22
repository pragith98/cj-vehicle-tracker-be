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

class Vehicle extends Model
{
    protected $table = 'vehicles';

    protected $fillable = [
        'mileage_tracker_id',
        'vehicle_no',
        'chassis_no',
        'current_mileage'
    ];

    public function ownerships()
    {
        return $this->hasMany(VehicleOwnership::class, 'vehicle_id');
    }

    public function currentOwnership()
    {
        return $this->hasOne(VehicleOwnership::class, 'vehicle_id')
            ->whereNull('end_date');
    }

    public function mileageTracker()
    {
        return $this->hasOne(MileageTracker::class, 'id', 'mileage_tracker_id');
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