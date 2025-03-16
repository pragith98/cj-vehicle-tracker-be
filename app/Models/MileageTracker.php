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
use Illuminate\Support\Facades\Auth;

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

    public function currentVehicle()
    {
        return $this->hasOne(Vehicle::class, 'mileage_tracker_id');
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