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
use Illuminate\Support\Facades\Auth;

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

    public function ownerships()
    {
        return $this->hasMany(VehicleOwnership::class, 'vehicle_owner_id');
    }

    public function currentOwnerships()
    {
        return $this->hasMany(VehicleOwnership::class, 'vehicle_owner_id')
            ->whereNull('end_date');
    }

    public function pastOwnerships()
    {
        return $this->hasMany(VehicleOwnership::class, 'vehicle_owner_id')
            ->whereNotNull('end_date');
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