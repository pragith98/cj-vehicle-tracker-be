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
 *     schema="VehicleOwnerResource",
 *     type="object",
 *     title="Vehicle Owner Resource",
 *     @OA\Property(property="id", type="integer", format="int64", example="1"),
 *     @OA\Property(property="NIC", type="string", example="772345598V"),
 *     @OA\Property(property="telephoneNo", type="string", example="0711212121"),
 *     @OA\Property(property="salutation", type="string", example="MR"),
 *     @OA\Property(property="name", type="string", example="Nishantha"),
 *     @OA\Property(property="currentOwnershipsCount", type="integer", example="1")
 * )
 */
class VehicleOwnerResource extends JsonResource
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
            'NIC' => $this->NIC,
            'telephoneNo' => $this->telephone_no,
            'salutation' => $this->salutation->name,
            'name' => $this->name,
            'currentOwnershipsCount' => $this->whenLoaded('currentOwnerships')->count()
        ];
    }

    public function with(Request $request)
    {
        return [
            'success' => true
        ];
    }
}