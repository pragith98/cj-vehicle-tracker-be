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
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @OA\Schema(
 *     schema="VehicleOwnerPaginatedCollection",
 *     type="object",
 *     title="Vehicle Owner Paginated Collection",
 *     @OA\Property(
 *          property="data", 
 *          type="array", 
 *          @OA\Items(ref="#/components/schemas/VehicleOwnerResource")
 *     ),
 *     @OA\Property(property="total", type="integer", format="int64", example=20),
 * )
 */
class VehicleOwnerPaginatedCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => VehicleOwnerResource::collection($this->collection['data']),
            'total' => $this->collection['total']
        ];
    }

    public function with(Request $request)
    {
        return [
            'success' => true
        ];
    }
}