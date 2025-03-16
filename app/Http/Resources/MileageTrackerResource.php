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
 *     schema="MileageTrackerResource",
 *     type="object",
 *     title="Mileage Tracker Resource",
 *     @OA\Property(property="id", type="integer", format="int64", example="1"),
 *     @OA\Property(property="serialNo", type="string", example="SE123123123"),
 *     @OA\Property(property="publicKey", type="string", example="99882233-334455"),
 *     @OA\Property(property="privateKey", type="string", example="7788-334433"),
 * )
 */
class MileageTrackerResource extends JsonResource
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
            'serialNo' => $this->serial_no,
            'publicKey' => $this->public_key,
            'privateKey' => $this->private_key,
            'status' => $this->status->name
        ];
    }

    public function with(Request $request)
    {
        return [
            'success' => true
        ];
    }
}