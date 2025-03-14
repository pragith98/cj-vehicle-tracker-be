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
 *     schema="MileageHistoryResource",
 *     type="object",
 *     title="Mileage History Resource",
 *     @OA\Property(property="vehicleId", type="integer", format="int64", example="1"),
 *     @OA\Property(property="mileage", type="double", example="10"),
 *     @OA\Property(property="createdAt", type="string", example="2025-03-14T22:22:39.000000Z"),
 * )
 */
class MileageHistoryResource extends JsonResource
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
            'mileage' => $this->mileage,
            'createdAt' => $this->created_at->format('Y-m-d H:i:s')
        ];
    }

    public function with(Request $request)
    {
        return [
            'success' => true
        ];
    }
}