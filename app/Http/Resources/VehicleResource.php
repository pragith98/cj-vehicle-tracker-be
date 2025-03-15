<?php

/*
 * @copyright (c) 2025 Pragith Lakshan Thilakarathna
 * All rights reserved. 
 * This code is proprietary to CJNextGenSys. 
 * Unauthorized use, reproduction, modification, distribution, or sale 
 * without the explicit written permission of CJNextGenSys is strictly prohibited.
 * For inquiries, please contact: [info@cjnextgensys.com]
*/

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="VehicleResource",
 *     type="object",
 *     title="Vehicle Resource",
 *     @OA\Property(property="id", type="integer", format="int64", example="1"),
 *     @OA\Property(property="mileageTrackerId", type="string", example="1"),
 *     @OA\Property(property="vehicleNo", type="string", example="WPAC3434"),
 *     @OA\Property(property="chassisNo", type="string", example="7788-334433"),
 *     @OA\Property(property="currentMileage", type="interger", example="300")
 * )
 */
class VehicleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'mileageTrackerId' => $this->mileage_tracker_id,
            'vehicleNo' => $this->vehicle_no,
            'chassisNo' => $this->chassis_no,
            'currentMileage' => $this->current_mileage
        ];
    }

    public function with(Request $request)
    {
        return [
            'success' => true
        ];
    }
}