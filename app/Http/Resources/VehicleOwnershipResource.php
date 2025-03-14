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
 *     schema="VehicleOwnershipResource",
 *     type="object",
 *     title="Vehicle Ownership Resource",
 *     @OA\Property(property="vehicleId", type="integer", example="1"),
 *     @OA\Property(property="vehicleOwnerId", type="integer", example="3"),
 *     @OA\Property(property="startDate", type="string", example="2024-12-01"),
 *     @OA\Property(property="endDate", type="string", example="2024-12-01")
 * )
 */
class VehicleOwnershipResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'vehicleId' => $this->vehicle_id,
            'vehicleOwnerId' => $this->vehicle_owner_id,
            'startDate' => $this->start_date,
            'endDate' => $this->end_date
        ];
    }

    public function with(Request $request)
    {
        return [
            'success' => true
        ];
    }
}